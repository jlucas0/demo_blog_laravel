<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class ApiController extends Controller{

    /**
     * Numeric status of the response.
     * @var int
     */
    protected int $status;

    /**
     * Text message to inform what happened.
     * @var string
     */
    protected string $message;

    /**
     * Extra information when needed.
     * @var mixed
     */
    protected mixed $payload;

    /**
     * Information of the errors if any.
     * @var array<string>
     */
    protected array $errors;

    /**
     * Parses all response fields to json and generates response.
     * @return JsonResponse
     */
    protected function generateResponse() : JsonResponse{
        $response = [
            "status" => $this->status,
            "message" => $this->message
        ];

        if(!empty($this->payload)){
            $response["payload"] = $this->payload;
        }

        if(!empty($this->errors)){
            $response["errors"] = $this->errors;
        }

        return response()->json($response);
    }

}