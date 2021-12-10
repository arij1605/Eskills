<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Participation;
use App\Form\ParticipationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/participation")
 */
class ParticipationController extends AbstractController
{
    /**
     * @Route("/", name="participation_index", methods={"GET"})
     */
    public function index(): Response
    {
        $participations = $this->getDoctrine()
            ->getRepository(Participation::class)
            ->findAll();

        return $this->render('participation/index.html.twig', [
            'participations' => $participations,
        ]);
    }

    /**
     * @Route("/new/{id}", name="participation_new", methods={"GET","POST"})
     */
    public function new($id): Response
    {
            $participation = new Participation();
            $participation->setIdUser($this->getUser());

            $event = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->find($id);
            $participation->setIdEvenement($event);
            $participation->setDate(new \DateTime());



            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($participation);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_byId', ['id'=>$id], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/{id}", name="participation_show", methods={"GET"})
     */
    public function show(Participation $participation): Response
    {
        return $this->render('participation/show.html.twig', [
            'participation' => $participation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="participation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Participation $participation): Response
    {
        $form = $this->createForm(ParticipationType::class, $participation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('participation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('participation/edit.html.twig', [
            'participation' => $participation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="participation_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $paticipation = $em->getRepository(Participation::class)->find($id);
        $em->remove($paticipation);
        $em->flush();
        return $this->redirectToRoute('evenement_byId', ['id'=>$paticipation->getIdEvenement()->getIdEvent()]);
    }

}
