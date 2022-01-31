<?php

namespace App\Controller;

use App\Entity\Scores;
use App\Entity\Sites;
use App\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ScoresFormType;
use Symfony\Component\HttpFoundation\JsonResponse;

class ScoresController extends AbstractController
{
    /**
     * @Route("/scores", name="scores")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $scores = $em->getRepository(Scores::class)->findAll();
        return $this->render('scores/index.html.twig', [
            'scores' => $scores,
        ]);
    }

    /**
     * @Route("/new-score", name="new_score")
     */
    public function addScore(Request $request)
    {
        $score = new Scores();
        $form = $this->createForm(ScoresFormType::class, $score);
        $form->handleRequest($request);
        $error = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $checkScoreDay = $em->getRepository(Scores::class)->checkScoreDay($score->getUsers(), $score->getSites(), $score->getScoreDate()->format('Y-m-d'));
            if ($checkScoreDay > 0) {
                $this->get('session')->getFlashBag()->add('error', 'Un utilisateur ne peut pas être pointé deux fois le même jour sur le même chantier.');
                $error = true;
            }

            $checkScoreLengthTime = $em->getRepository(Scores::class)->checkScoreLengthTime($score->getUsers(), $score->getSites(), $score->getScoreDate()->format('Y-m-d'));
            $totalLengthTime = $checkScoreLengthTime + $score->getLengthTime();
            if ($totalLengthTime > 35) {
                $this->get('session')->getFlashBag()->add('error', 'La somme des durées des pointages d\'un utilisateur pour une semaine ne pourra pas dépasser 35 heures.');
                $error = true;
            }
            if (!$error) {
                $em->persist($score);
                $em->flush();
                $this->get('session')->getFlashBag()->add('notice', 'Enregistrement effectué avec succès ');
                return $this->redirectToRoute('new_score');
            }
        }

        return $this->render("scores/new.html.twig", [
            "form" => $form->createView(),
        ]);
    }

    /**
     * @Route("/check-score/", name="check_score")
     */
    public function checkScoreDay(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $request->get('users');
        $sites = $request->get('sites');
        $scoreDate = $request->get('scoreDate');
        $lengthTime = $request->get('lengthTime');
        $user = $em->getRepository(Users::class)->find($users);
        $site = $em->getRepository(Sites::class)->find($sites);

        if ($scoreDate) {
            $checkScoreDay = $em->getRepository(Scores::class)->checkScoreDay($user, $site, $scoreDate);
            if ($checkScoreDay > 0) {
                return new JsonResponse(['status' => 500, 'message' => 'Un utilisateur ne peut pas être pointé deux fois le même jour sur le même chantier.']);
            }
        }
        if ($lengthTime && $scoreDate  ) {
            $checkScoreLengthTime = $em->getRepository(Scores::class)->checkScoreLengthTime($user, $site, $scoreDate);
            $totalLengthTime = $checkScoreLengthTime + $lengthTime;
            if ($totalLengthTime > 35) {
                return new JsonResponse(['status' => 500, 'message' => 'La somme des durées des pointages d\'un utilisateur pour une semaine ne pourra pas dépasser 35 heures.']);
            }
        }
        return new JsonResponse(['status' => 200]);
    }


}
