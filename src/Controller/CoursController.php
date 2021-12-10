<?php

namespace App\Controller;

use App\Entity\Cours;
use App\Form\CoursType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoursController extends AbstractController
{
    /**
     * @Route("/coursback", name="cours_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $cours = $entityManager
            ->getRepository(Cours::class)
            ->findAll();
        $cours = $paginator->paginate(
            $cours,//on passe les données
            $request->query->getInt('page',1),//numéro de la page en cours 1 par défaut
            4
        );

        return $this->render('cours/index.html.twig', [
            'cours' => $cours,
        ]);
    }
    /**
     * @Route("/coursfront", name="cours_index_front", methods={"GET"})
     */
    public function index_front(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
    {
        $cours = $entityManager
            ->getRepository(Cours::class)
            ->findAll();
        $cours = $paginator->paginate(
            $cours,//on passe les données
            $request->query->getInt('page',1),//numéro de la page en cours 1 par défaut
            4
        );
        return $this->render('cours/index.front.html.twig', [
            'cours' => $cours,
        ]);
    }

    /**
     * @Route("/newcours", name="cours_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cour = new Cours();
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $cour->getUploadFile();
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/new.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{idcours}/showfrontcours", name="cours_show_front", methods={"GET"})
     */
    public function show_front(Cours $cour): Response
    {
        return $this->render('cours/show.front.html.twig', [
            'cour' => $cour,
        ]);
    }
    /**
     * @Route("/{idcours}/showbackcours", name="cours_show", methods={"GET"})
     */
    public function show(Cours $cour): Response
    {
        return $this->render('cours/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    /**
     * @Route("/{idcours}/editcours", name="cours_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CoursType::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cours/edit.html.twig', [
            'cour' => $cour,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idcours}/deletecours", name="cours_delete", methods={"POST"})
     */
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getIdcours(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cours_index', [], Response::HTTP_SEE_OTHER);
    }
}
