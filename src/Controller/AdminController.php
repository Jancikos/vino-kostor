<?php

namespace App\Controller;

use App\Utils\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends BaseController
{
    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        $this->addBreadcrumb('Dashboard', 'admin_index');

        return $this->renderAdminPage(
            'Admin dashboard',
            'index',
            [
                'controller_name' => 'MainController',
            ]
        );
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $this->addBreadcrumb('Login', 'admin_login');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->renderAdminPage(
            'Prihlásenie',
            'login',
            [
                'last_username' => $lastUsername,
                'error'         => $error,
            ]
        );
    }
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(): void
    {
        // controller can be blank: it will never be called!
    }


    /**
     * @param string $title citatelna nazev stranky
     * @param string $page nazov twigu, musi byt v adresari templates/admin/pages a mat strukturu `admin_$page.html.twig`
     * @param array $params parametre nasledne pre twig
     * @return Response
     */
    protected function renderAdminPage(string $title, string $page, array $params = []): Response
    {
        return $this->render("admin/pages/admin_$page.html.twig", [
            'title' => $title,
            'breadcrumbs' => $this->getBreadcrumbs(),
        ] + $params);
    }
}
