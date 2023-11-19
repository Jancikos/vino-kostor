<?php

namespace App\Utils\JsonResponse;

use App\Utils\Validation\IValidableModel;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * sluzi na zjednodusnie tvorby json odpovede pri validacii formularov
 */
class JsonValidationResponse extends JsonDataResponse
{
    /** @var array [FIELD => MESSAGES[]] pole s chybovymi spravami */
    private array $errorMessages = [];
 
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
        parent::__construct($success, "", $data);
        $this->errorMessages = $errorMessages;
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
     * @todo zlepsi navrh
     * 
     * @return JsonResponse
     */
    public function toJsonResponse() : JsonResponse {
        return new JsonResponse([
            'success' => $this->getSuccess(),
            'errorMessages' => $this->geterrorMessages(),
            'data' => $this->getData()
        ]);
    }
}
