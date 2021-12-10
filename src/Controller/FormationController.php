<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationController extends AbstractController
{
    /**
     * @Route("/formationback", name="formation_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
{
    $formations = $entityManager
        ->getRepository(Formation::class)
        ->findAll();
    $formations = $paginator->paginate(
        $formations,//on passe les données
        $request->query->getInt('page',1),//numéro de la page en cours 1 par défaut
        4
    );
    return $this->render('formation/index.html.twig', [
        'formations' => $formations,
    ]);
}
    /**
     * @Route("/formationfront", name="formation_index_front", methods={"GET"})
     */
    public function index_front(EntityManagerInterface $entityManager, Request $request, PaginatorInterface $paginator): Response
{
    $formations = $entityManager
        ->getRepository(Formation::class)
        ->findAll();
    $formations = $paginator->paginate(
        $formations,//on passe les données
        $request->query->getInt('page',1),//numéro de la page en cours 1 par défaut
        4
    );
    return $this->render('formation/index.front.html.twig', [
        'formations' => $formations,
    ]);
}

    /**
     * @Route("/newformation", name="formation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();
            $message = (new \Swift_Message())
                ->setFrom('fares.moalla1996@gmail.com')
                ->setTo('arijncibi5@gmail.com')
                ->setSubject('formation ajoutée')
                ->setBody('<p>votre création de formation a été ajoutée. Nous vous répondrons dans les meilleurs delais</p>', 'text/html');
            $mailer->send($message);
            return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idformation}/showbackformation", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
{
    return $this->render('formation/show.html.twig', [
        'formation' => $formation,
    ]);
}
    /**
     * @Route("/{idformation}/showfrontformation", name="formation_show_front", methods={"GET"})
     */
    public function show_front(Formation $formation): Response
{
    return $this->render('formation/show.front.html.twig', [
        'formation' => $formation,
    ]);
}

    /**
     * @Route("/{idformation}/editformation", name="formation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(FormationType::class, $formation);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager->flush();

        return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('formation/edit.html.twig', [
        'formation' => $formation,
        'form' => $form->createView(),
    ]);
}

    /**
     * @Route("/{idformation}/deleteformation", name="formation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$formation->getIdformation(), $request->request->get('_token'))) {
        $entityManager->remove($formation);
        $entityManager->flush();
    }

    return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
}

}
