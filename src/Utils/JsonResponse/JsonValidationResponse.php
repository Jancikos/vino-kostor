<?php

namespace App\Utils\JsonResponse;

use App\Utils\Validation\IValidableModel;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * sluzi na zjednodusnie tvorby json odpovede pri validacii formularov
 */
class JsonValidationResponse
{
    /** @var bool ci validacia presla */
    private bool $success;

    /** @var array [FIELD => MESSAGES[]] pole s chybovymi spravami */
    private array $errorMessages = [];
    /** @var array [KEY => VALUE] pole s dodatocnymi datamai */
    private array $data = [];

    /**
     * @param IValidableModel $model
     * @return self zvaliduje model a vrati instanciu tejto triedy
     */
    public static function ValidateModel(IValidableModel $model) : self {
        $response = new self();

        if (!$model->validate()) {
            $response->setFailed();
            
            foreach ($model->getValidationFailures() as $failure) {
                $response->addErrMessage($failure->getPropertyPath(), $failure->getMessage());
            }
        }

        return $response;
    }

    public function __construct($success = true, $errorMessages = [], $data = [])
    {
        $this->success = $success;
        $this->errorMessages = $errorMessages;
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
    public function geterrorMessages(): array
    {
        return $this->errorMessages;
    }

    /**
     * @param array $errorMessages
     * @return self
     */
    public function seterrorMessages(array $errorMessages): self
    {
        $this->errorMessages = $errorMessages;
        return $this;
    }

    /**
     * @param string $field
     * @param string $message
     * @return self
     */
    public function addErrMessage(string $field, string $message): self
    {
        if (!isset($this->errorMessages[$field])) {
            $this->errorMessages[$field] = [];
        }
        $this->errorMessages[$field][] = $message;
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
     * @return JsonResponse
     */
    public function toJsonResponse() : JsonResponse {
        return new JsonResponse([
            'success' => $this->success,
            'errorMessages' => $this->errorMessages,
            'data' => $this->data
        ]);        
    }
}
