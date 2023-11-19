<?php

namespace App\Controller;

use App\Utils\Controller\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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

        return $this->renderAdminPage(
            'Admin dashboard',
            'index',
            [
                'controller_name' => 'MainController',
            ]
        );
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
