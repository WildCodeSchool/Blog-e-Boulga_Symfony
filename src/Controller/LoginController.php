<?php

namespace App\Controller;

use LogicException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Note : à rajouter sur les routes admin 👇🏻
 * use Symfony\Component\Security\Http\Attribute\IsGranted;
 */

class LoginController extends AbstractController
{
    #[Route(path: '/admin/login', name: 'app_login')]
    /**
     * Note : à rajouter sur les routes admin 👇🏻
     * #[IsGranted('VOTER_ADMIN', statusCode: 403, message: 'Vous n\'avez pas les droits pour accéder à cette page')]
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_admin_article_index');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/login/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'page' => 'login'
        ]);
    }

    #[Route(path: '/admin/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new LogicException('This method can be blank - intercepted by the logout key on your firewall.');
    }
}
