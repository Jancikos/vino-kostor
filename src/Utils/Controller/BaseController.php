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

    public function addBreadcrumb($title, $route) {
        $this->breadcrumbs[] = new Breadcrumb($title, $route);
    }
}
