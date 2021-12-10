<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/admin", name="adminlogin")
     */
    public function afterloginadmin(AuthenticationUtils $authenticationUtils): Response
    {


        return $this->render('back.html.twig');
    }


    /**
     * @Route("/formateur", name="formateurlogin")
     */
    public function afterloginformateur(AuthenticationUtils $authenticationUtils): Response
    {


        return $this->render('FormateurFront.html.twig');
    }

    /**
     * @Route("/etudiant", name="etudiantlogin")
     */
    public function etudiantloginadmin(AuthenticationUtils $authenticationUtils): Response
    {


        return $this->render('front.html.twig');
    }

}
