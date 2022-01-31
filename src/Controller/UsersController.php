<?php

namespace App\Controller;

use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\UsersFormType;

class UsersController extends AbstractController
{
    /**
     * @Route("/", name="users")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository( Users::class)->findAll();
        return $this->render('users/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/new-user", name="new_user")
     */
    public function addUser(Request $request)
    {
        $user = new Users();
        $form = $this->createForm(UsersFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Enregistrement effectué avec succès ');
            return $this->redirectToRoute('new_user');
        }

        return $this->render("users/new.html.twig", [
            "form" => $form->createView(),
        ]);
    }
    /**
     * @Route("/edit-user/{id}", name="edit_user")
     */
    public function editUser(Request $request, Users $users)
    {
        $form = $this->createForm(UsersFormType::class, $users);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->get('session')->getFlashBag()->add('notice', 'Enregistrement effectué avec succès ');
            return $this->redirectToRoute('edit_user',array('id'=> $users->getId()));
        }

        return $this->render("users/edit.html.twig", [
            "form" => $form->createView(),
        ]);
    }
}
