<?php

namespace App\Controller;

use App\Entity\Note;
use App\Entity\Users;
use App\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/note")
 */
class NoteController extends AbstractController
{
    /**
     * @Route("/", name="note_index", methods={"GET"})
     */
    public function index(): Response
    {
        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findAll();

        return $this->render('note/index.html.twig', [
            'notes' => $notes,
        ]);
    }


    /**
     * @Route("/users", name="note_user")
     */
    public function users(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();

        return $this->render('note/users.html.twig', [
            'users' => $users,
        ]);
    }



    /**
     * @Route("/mesnotes", name="mes_note")
     */
    public function mesNotes(): Response
    {
        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findBy(array('idUser'=>$this->getUser()));
        $total = 0;
        $nbr = 0;
        $moyenne=0;
        foreach ($notes as $note){

            $total = $total+$note->getNote();
            $nbr++;
        }
        if ($nbr == 0){
            $moyenne = 'pas de note effecter';
        }
        else {
        $moyenne = $total/$nbr ;
        }
        return $this->render('note/indexEtudiant.html.twig', [
            'notes' => $notes,
            'moyenne'=>$moyenne
        ]);
    }




    /**
     * @Route("/new/{iduser}", name="note_new")
     */
    public function new(Request $request , $iduser): Response
    {
        $note = new Note();
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);
        $user = $this->getDoctrine()
            ->getRepository(Users::class)
            ->find($iduser);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $note->setIdUser($user);
            $entityManager->persist($note);
            $entityManager->flush();

            return $this->redirectToRoute('note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note/new.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idNote}", name="note_show", methods={"GET"})
     */
    public function show(Note $note): Response
    {
        return $this->render('note/show.html.twig', [
            'note' => $note,
        ]);
    }

    /**
     * @Route("/{idNote}/edit", name="note_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Note $note): Response
    {
        $form = $this->createForm(NoteType::class, $note);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('note_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('note/edit.html.twig', [
            'note' => $note,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{idNote}", name="note_delete")
     */
    public function delete($idNote)
    {

        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository(Note::class)->find($idNote);
        $em->remove($examen);
        $em->flush();
        return $this->redirectToRoute('note_index');
    }

}
