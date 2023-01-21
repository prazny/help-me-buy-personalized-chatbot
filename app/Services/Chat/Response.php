<?php

namespace App\Services\Chat;

class Response
{
    private int $storyNo;
    private string $responseType;
    private string|array $message;
    private array $values;
    private string $valueType;

    public function __construct(int $storyNo, string $responseType, string|array $message, array $values, string $valueType)
    {
        $this->storyNo = $storyNo;
        $this->responseType = $responseType;
        $this->message = $message;
        $this->values = $values;
        $this->valueType = $valueType;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'response_type' => $this->responseType,
            'values' => $this->values,
            'value_type' => $this->valueType,
        ];
    }


}
