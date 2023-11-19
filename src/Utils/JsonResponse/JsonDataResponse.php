<?php

namespace App\Utils\JsonResponse;

use App\Utils\Validation\IValidableModel;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * sluzi na zjednodusnie tvorby json odpovede
 */
class JsonDataResponse
{
    /** @var bool ci je odpoved succesful alebo failed */
    private bool $success;

    private string $title = '';
    /** @var array [KEY => VALUE] pole s dodatocnymi datamai */
    private array $data = [];

    /**
     * @return self
     */
    public static function SuccessResponse($title="") : self {
        $response = new self(true, $title);
        return $response;
    }

    /**
     * @param string $title
     * @return self
     */
    public static function FailedResponse($title="") : self {
        $response = new self(false, $title);
        return $response;
    }

    public function __construct($success = true, $title="", $data = [])
    {
        $this->success = $success;
        $this->title = $title;
        $this->data = $data;
    }

	/**
	 * @return bool
	 */
	public function getSuccess() : bool
	{
		return $this->success;
	}

	/**
     * @param bool $succes default true
	 * @return self
	 */
	public function setSuccess(bool $succes = true) : self
	{
		$this->success = true;
		return $this;
	}
    /**
	 * @return self
	 */
	public function setFailed() : self
	{
		$this->success = false;
		return $this;
	}

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }
    
    /**
     * @param array $data
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }
    
    /**
     * @param string $key
     * @param string $value
     * @return self
     */
    public function addData(string $key, string $value): self
    {
        $this->data[$key] = $value;
        return $this;
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
     * @return JsonResponse
     */
    public function toJsonResponse() : JsonResponse {
        return new JsonResponse([
            'success' => $this->success,
            'title' => $this->title,
            'data' => $this->data
        ]);        
    }
}
