<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Entity\Evenement;
use App\Entity\Participation;
use App\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commentaire")
 */
class CommentaireController extends AbstractController
{
    /**
     * @Route("/", name="commentaire_index", methods={"GET"})
     */
    public function index(): Response
    {
        $commentaires = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findAll();

        return $this->render('commentaire/index.html.twig', [
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * @Route("/new", name="commentaire_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $entityManager->flush();

            return $this->redirectToRoute('commentaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commentaire/new.html.twig', [
            'commentaire' => $commentaire,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commentaire_show", methods={"GET"})
     */
    public function show(Commentaire $commentaire): Response
    {
        return $this->render('commentaire/show.html.twig', [
            'commentaire' => $commentaire,
        ]);
    }

    /**
     * @Route("/{id}/{ide}/edit", name="commentaire_edit", methods={"GET","POST"})
     */
    public function edit(Request $request,$ide, Commentaire $commentaire): Response
    {

        $evenement = $this->getDoctrine()
            ->getRepository(Evenement::class)
            ->find($ide);

        $comments = $this->getDoctrine()
            ->getRepository(Commentaire::class)
            ->findBy(array('idEvenement'=>$ide));
        $particpation = $this->getDoctrine()
            ->getRepository(Participation::class)
            ->findOneBy(array('idEvenement'=>$ide,
                'idUser'=>$this->getUser()));


        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('evenement_byId', ['id'=>$ide], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/detailsevnt.html.twig', [
            'evenement' => $evenement,
            'usercon'=>$this->getUser(),
            'participation'=>$particpation,
            'form' => $form->createView(),
            'comments'=> $comments

        ]);
    }

    /**
     * @Route("/delete/{id}", name="comment_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentaire = $em->getRepository(Commentaire::class)->find($id);
        $em->remove($commentaire);
        $em->flush();
        return $this->redirectToRoute('evenement_byId', ['id'=>$commentaire->getIdEvenement()->getIdEvent()]);
    }
}
