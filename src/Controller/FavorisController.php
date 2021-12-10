<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Favoris;
use App\Form\FavorisType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/favoris")
 */
class FavorisController extends AbstractController
{
    /**
     * @Route("/", name="favoris_index", methods={"GET"})
     */
    public function index(): Response
    {
        $favoris = $this->getDoctrine()
            ->getRepository(Favoris::class)
            ->findBy(array('idUser'=>$this->getUser()));

        return $this->render('favoris/index.html.twig', [
            'favoris' => $favoris,
        ]);
    }

    /**
     * @Route("/new", name="favoris_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $data = $request->getContent();
        $obj = json_decode($data,true);
        $favoris = new Favoris();

        $em = $this->getDoctrine()->getManager();
        $idc = $obj['evenement'];
        $Evenement = $em->getRepository(Evenement::class)->find($idc);
        $user = $this->getUser();
        $favoris->setIdUser($user);
        $favoris->setIdEvenement($Evenement);

        $em->persist($favoris);
        $em->flush();
        return new Response($favoris->getIdEvenement());
    }

    /**
     * @Route("/{id}", name="favoris_show", methods={"GET"})
     */
    public function show(Favoris $favori): Response
    {
        return $this->render('favoris/show.html.twig', [
            'favori' => $favori,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="favoris_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Favoris $favori): Response
    {
        $form = $this->createForm(FavorisType::class, $favori);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('favoris_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('favoris/edit.html.twig', [
            'favori' => $favori,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="favoris_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $favoris = $em->getRepository(Favoris::class)->find($id);
        $em->remove($favoris);
        $em->flush();
        return $this->redirectToRoute('favoris_index');
    }




}
