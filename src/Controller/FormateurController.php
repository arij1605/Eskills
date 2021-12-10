<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


/**
 * @Route("/admin")
 */
class FormateurController extends AbstractController
{
    /**
     * @Route("/new", name="new_formateur")
     */
    public function new(Request $request, UserPasswordEncoderInterface $userPasswordEncoderInterface): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $roles[] = 'ROLE_FORMATEUR';
            $user->setRoles($roles);
            // encode the plain password
            $user->setPassword(
                $userPasswordEncoderInterface->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('users_index');
        }

        return $this->render('formateur/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/", name="users_index", methods={"GET"})
     */
    public function index(): Response
    {
        $evenements = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();

        return $this->render('formateur/index.html.twig', [
            'users' => $evenements,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Users $users): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('users_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formateur/edit.html.twig', [
            'users' => $users,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/delete/{id}", name="users_delete")
     */
    public function delete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $examen = $em->getRepository(Users::class)->find($id);
        $em->remove($examen);
        $em->flush();
        return $this->redirectToRoute('users_index');
    }


    /**
     * @Route("/userlist", name="userlist", methods={"GET"})
     */
    public function userIndex(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(Users::class)
            ->findAll();

        return $this->render('formateur/ListUsers.html.twig', [
            'users' => $users,
        ]);
    }





}
