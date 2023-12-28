<?php

namespace App\Utils\Controller;

use App\Controller\AdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Breadcrumb
{
    private string $title;
    private string $route;
    private array $routeParams = [];

    public function __construct(string $title, string $route, array $routeParams = [])
    {
        $this->title = $title;
        $this->route = $route;
        $this->routeParams = $routeParams;
    }

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $title 
	 * @return self
	 */
	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 * @param string $route 
	 * @return self
	 */
	public function setRoute($route)
	{
		$this->route = $route;
		return $this;
	}

    /**
     * @return array
     */
    public function getRouteParams()
    {
        return $this->routeParams;
    }

    /**
     * @param array $routeParams 
     * @return self
     */
    public function setRouteParams($routeParams)
    {
        $this->routeParams = $routeParams;
        return $this;
    }
}
