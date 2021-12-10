<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Form\ExamenType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/examen")
 */
class ExamenController extends AbstractController
{
    /**
     * @Route("/", name="examen_index", methods={"GET"})
     */
    public function index(): Response
    {
        $examens = $this->getDoctrine()
            ->getRepository(Examen::class)
            ->findAll();

        return $this->render('examen/index.html.twig', [
            'examens' => $examens,
        ]);
    }

    /**
     * @Route("/adminaffiche", name="examne_affiche")
     */
    public function AdminAffiche(): Response
    {
        $examens = $this->getDoctrine()
            ->getRepository(Examen::class)
            ->findBy(array("etat"=>"En cours"));

        return $this->render('examen/afficheadmin.html.twig', [
            'examens' => $examens,
        ]);
    }
    /**
     * @Route("/front", name="examen_index_front", methods={"GET"})
     */
    public function AfficheFrontExamen(): Response
    {
        $examens = $this->getDoctrine()
            ->getRepository(Examen::class)
            ->findAll();

        return $this->render('examen/indexFront.html.twig', [
            'examens' => $examens,
        ]);
    }


    /**
     * @Route("/new", name="examen_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $examan = new Examen();
        $form = $this->createForm(ExamenType::class, $examan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $examan->setEtat("En cours");

            $examan->getUploadFileCorrection();
            $examan->getUploadFile();
            $entityManager->persist($examan);
            $entityManager->flush();

            return $this->redirectToRoute('examen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('examen/new.html.twig', [
            'examan' => $examan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idExamen}", name="examen_show", methods={"GET"})
     */
    public function show(Examen $examan): Response
    {
        return $this->render('examen/show.html.twig', [
            'examan' => $examan,
        ]);
    }

    /**
     * @Route("/{idExamen}/edit", name="examen_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Examen $examan): Response
    {
        $form = $this->createForm(ExamenType::class, $examan);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('examen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('examen/edit.html.twig', [
            'examan' => $examan,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="examen_delete")
     */
    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository(Examen::class)->find($id);
        $em->remove($examen);
        $em->flush();
        return $this->redirectToRoute('examen_index');
    }

    /**
     * @Route("/accepter/{idexamen}", name="examen_accepter", methods={"GET","POST"})
     */
    public function accepter(Request $request,  $idexamen): Response
    {
        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository(Examen::class)->find($idexamen);
        $examen->setEtat('Accepté');
        $this->getDoctrine()->getManager()->persist($examen);
        $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('examne_affiche', [], Response::HTTP_SEE_OTHER);

    }

    /**
     * @Route("/refuser/{idexamen}", name="examen_refuser", methods={"GET","POST"})
     */
    public function refuser(Request $request,  $idexamen): Response
    {
        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository(Examen::class)->find($idexamen);
        $examen->setEtat('Refusé');
        $this->getDoctrine()->getManager()->persist($examen);
        $this->getDoctrine()->getManager()->flush();

        return $this->redirectToRoute('examne_affiche', [], Response::HTTP_SEE_OTHER);

    }






}
