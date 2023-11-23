<?php

namespace App\Utils\Controller;

use App\Controller\AdminController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Breadcrumb
{
    private string $title;
    private string $route;

    public function __construct(string $title, string $route)
    {
        $this->title = $title;
        $this->route = $route;
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
}
