<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Reponse;
use App\Form\QuestionType;
use App\Form\ReponseType;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/question")
 */
class QuestionController extends AbstractController
{


    /**
     * @Route("/pdf/{id}", name="telecharger_pdf")
     */
    public function pdf($id)
    {
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find($id);

        $reponse = $this->getDoctrine()
            ->getRepository(Reponse::class)
            ->findBy(array('idQuestion'=>$id));


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('question/pdfQuestion.html.twig', [
            'question' => $questions,
            'rep' => $reponse
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("questionnaire.pdf", [
            "Attachment" => false
        ]);
    }





    /**
     * @Route("/", name="question_index", methods={"GET"})
     */
    public function index(): Response
    {
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();

        return $this->render('question/index.html.twig', [
            'questions' => $questions,
            'user'=>$this->getUser()
        ]);
    }

    /**
     * @Route("/new", name="question_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $question->setIdUser($this->getUser());
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/new.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idQuestion}", name="question_show", methods={"GET","POST"})
     */
    public function show(Question $question,Request $request): Response
    {

        $reponse = new Reponse();

        $form = $this->createForm(ReponseType::class, $reponse);
        $form->handleRequest($request);
        $rep = $this->getDoctrine()
            ->getRepository(Reponse::class)
            ->findBy(array('idQuestion'=>$question->getIdQuestion()));

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $reponse->setIdUser($this->getUser());
            $reponse->setIdQuestion($question);
            $entityManager->persist($reponse);
            $entityManager->flush();

            return $this->redirectToRoute('question_show', ['idQuestion'=>$question->getIdQuestion()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'reponse' => $rep,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idQuestion}/edit", name="question_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Question $question): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('question/edit.html.twig', [
            'question' => $question,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="question_delete")
     */
    public function delete($id)
    {

        $em = $this->getDoctrine()->getManager();
        $q= $em->getRepository(Question::class)->find($id);
        $em->remove($q);
        $em->flush();
        return $this->redirectToRoute('question_index');
    }



}
