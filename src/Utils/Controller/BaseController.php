<?php

namespace App\Utils\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BaseController extends AbstractController
{
    /** @var array<Breadcrumb> */
    private array $breadcrumbs = [];

    /**
     * @return array<Breadcrumb>
     */
    public function getBreadcrumbs() {
        return $this->breadcrumbs;
    }

    
    /**
     * @param string $title 
     * @param string $route 
     * @param array $params default []
     * @return void 
     */
    public function addBreadcrumb(string $title, string $route, array $params = []) {
        $this->breadcrumbs[] = new Breadcrumb($title, $route, $params);
    }

    /**
     * @return bool ci ma user rolu ROLE_SUPER_ADMIN
     */
    public function isSuperAdmin() : bool {
        return $this->isGranted('ROLE_SUPER_ADMIN');
    }
}
