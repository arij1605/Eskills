<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Entity\Favoris;
use App\Entity\Participation;
use App\Entity\Vote;
use App\Form\CommentaireType;
use App\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{
    /**
     * @Route("/", name="evenement_index", methods={"GET"})
     */
    public function index(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();

        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenements,
        ]);
    }


    /**
     * @Route("/details/{id}", name="evenement_byId", methods={"GET","Post"})
     */
    public function evenmentbyId($id,Request $request): Response
    {

        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        $evenement = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->find($id);

        $vote = $this->getDoctrine()
            ->getRepository(Vote::class)
            ->findAll();

        $favoris = $this->getDoctrine()
            ->getRepository(Favoris::class)
            ->findOneBy(array('idEvenement' => $id, 'idUser'=>$this->getUser()));

        $comments = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findBy(array('idEvenement'=>$id));


        $particpation = $this->getDoctrine()
            ->getRepository(Participation::class)
            ->findOneBy(array('idEvenement'=>$id,
                'idUser'=>$this->getUser()));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $commentaire->setIdEvenement($evenement);
            $commentaire->setIdUser($this->getUser());
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_byId', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }



//        $evenement->setNbrVue($n+1);
//        $this->getDoctrine()->getManager()->flush();


        return $this->render('evenement/detailsevnt.html.twig', [
            'evenement' => $evenement,
            'usercon'=>$this->getUser(),
            'participation'=>$particpation,
            'form' => $form->createView(),
            'comments'=> $comments,
            'favoris'=>$favoris,
            'vote'=>$vote

        ]);
    }



    /**
     * @Route("/front", name="evenement_indexFront", methods={"GET"})
     */
    public function AfficheFront(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->findAll();

        return $this->render('evenement/indexFront.html.twig', [
            'evenements' => $evenements,
        ]);
    }



    /**
     * @Route("/new", name="evenement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idEvent}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{idEvent}/edit", name="evenement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Evenement $evenement): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="evenement_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository(Evenement::class)->find($id);
        $em->remove($examen);
        $em->flush();
        return $this->redirectToRoute('evenement_index');
    }


}
