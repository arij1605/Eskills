<?php

namespace App\Controller;

use App\Entity\Examen;
use App\Entity\Formation;
use App\Entity\Reclamtion;
use App\Entity\Users;
use App\Form\ReclamtionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/reclamtion")
 */
class ReclamtionController extends AbstractController

{

    /**
     * @Route("/frontreclamation", name="reclamtion_client",methods={"GET"})
     */
    public function client():Response
    {

        $userconnecter = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($this->getUser());

        $reclamtions = $this->getDoctrine()
            ->getRepository(Reclamtion::class)
            ->findBy(array("idUser"=>$userconnecter->getId()));

        return $this->render('reclamtion/indexClient.html.twig', [
            'reclamtions' => $reclamtions,
        ]);
    }



    /**
     * @Route("/", name="reclamtion_index", methods={"GET"})
     */
    public function index(): Response
    {
        $reclamtions = $this->getDoctrine()
            ->getRepository(Reclamtion::class)
            ->findAll();

        $reclamtion = $this->getDoctrine()
            ->getRepository(Reclamtion::class)
            ->findBy(array('etat'=>'non traiter'));
        $count=0;
        foreach ($reclamtion as $reclamtion){
            $count++;
    }

        return $this->render('reclamtion/index.html.twig', [
            'reclamtions' => $reclamtions,
            'count'=>$count
        ]);
    }

    /**
     * @Route("/formation", name="formation_index", methods={"GET"})
     */
    public function indexformation(): Response
    {
        $formations = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->findAll();

        return $this->render('reclamtion/showformation.html.twig', [
            'formations' => $formations,
        ]);
    }

    /**
     * @Route("/new/{id}", name="reclamtion_new", methods={"GET","POST"})
     */
    public function new(Request $request, $id): Response
    {
        $reclamtion = new Reclamtion();
        $form = $this->createForm(ReclamtionType::class, $reclamtion);
        $form->handleRequest($request);
        $formation = $this->getDoctrine()
            ->getRepository(Formation::class)
            ->find($id);
        $userconnecter = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reclamtion->setEtat('non traiter');
            $reclamtion->setIdUser($userconnecter);
            $reclamtion->setIdFormation($formation);
            $reclamtion->setDaterec(new \DateTime());
            $entityManager->persist($reclamtion);
            $entityManager->flush();

            return $this->redirectToRoute('reclamtion_client', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamtion/new.html.twig', [
            'reclamtion' => $reclamtion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idRec}", name="reclamtion_show", methods={"GET"})
     */
    public function show(Reclamtion $reclamtion): Response
    {
        return $this->render('reclamtion/show.html.twig', [
            'reclamtion' => $reclamtion,
        ]);
    }




    /**
     * @Route("/{idRec}/edit", name="reclamtion_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Reclamtion $reclamtion): Response
    {
        $form = $this->createForm(ReclamtionType::class, $reclamtion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamtion_client', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamtion/edit.html.twig', [
            'reclamtion' => $reclamtion,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="reclamation_delete")
     */
    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository(Reclamtion::class)->find($id);
        $em->remove($examen);
        $em->flush();
        return $this->redirectToRoute('reclamtion_client');
    }


    /**
     * @Route("/accepter/{idrec}", name="reclamation_accept", methods={"GET","POST"})
     */
    public function accepter(Request $request,  $idrec , \Swift_Mailer $mailer): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $reclamation = $this->getDoctrine()
            ->getRepository(Reclamtion::class)
            ->find($idrec);
        $reclamation->setEtat("Traité");

        $message = (new \Swift_Message('Your Reclamation est bien traité'))
            ->setFrom('sirineghommidh@gmail.com')
            ->setTo($reclamation->getIdUser()->getEmail())
            ->setBody(
                $this->renderView(
                    'reclamtion/email.html.twig',
                    [ 'reclamation' => $reclamation,]
                ),
                'text/html'
            )

            // you can remove the following code if you don't define a text version for your emails
            ->addPart(
                $this->renderView(
                // templates/emails/registration.txt.twig
                    'reclamtion/email.html.twig',
                    [ 'reclamation' => $reclamation,]
                ),
                'text/plain'
            )
        ;

        $mailer->send($message);




        $entityManager->flush();
        $this->getDoctrine()->getManager()->flush();
        return $this->redirectToRoute('reclamtion_index');
    }






}
