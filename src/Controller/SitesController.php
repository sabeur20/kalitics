<?php

namespace App\Controller;

use App\Entity\Sites;
use App\Entity\Scores;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SitesFormType;

class SitesController extends AbstractController
{
    /**
     * @Route("/sites", name="sites")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $sites = $em->getRepository( Sites::class)->findAll();
        return $this->render('sites/index.html.twig', [
            'sites' => $sites,
        ]);
    }
    /**
     * @Route("/new-site", name="new_site")
     */
    public function addSite(Request $request)
    {
        $site = new Sites();
        $form = $this->createForm(SitesFormType::class, $site);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($site);
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Enregistrement effectué avec succès ');
            return $this->redirectToRoute('new_site');
        }

        return $this->render("sites/new.html.twig", [
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit-site/{id}", name="edit_site")
     */
    public function editSite(Request $request, Sites $sites)
    {
        $form = $this->createForm(SitesFormType::class, $sites);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Enregistrement effectué avec succès ');
            return $this->redirectToRoute('edit_site',array('id'=> $sites->getId()));
        }

        return $this->render("sites/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/show-site/{id}", name="show_site")
     */
    public function showSite(Sites $sites)
    {
        $em = $this->getDoctrine()->getManager();
        $scoreUsers = $em->getRepository(Scores::class)->scoreUsersSite( $sites );
        $scoreSumLengthTime = $em->getRepository(Scores::class)->scoreSumLengthTimeSite( $sites );
        return $this->render('sites/show.html.twig', [
            'sites' => $sites,
            'scoreUsers'=>$scoreUsers??0,
            'scoreSumLengthTime'=>$scoreSumLengthTime??0
        ]);
    }

}
