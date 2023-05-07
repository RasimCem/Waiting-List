<?php
namespace app\response;

class Response
{

    private string $message;
    private array $data;

    private int $statusCode;


    public function __construct(string $message, array $data, int $statusCode = 200)
    {
        $this->message = $message;
        $this->data = $data;
    }

    public function successResponse(int $statusCode = 400)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function errorResponse(int $statusCode = 400)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function getJson()
    {
        return json_encode([
            'message' => $this->message,
            'data' => $this->data,
            'status_code' => $this->statusCode
        ], true);
    }

    static function successResponseJson(string $message = "", array $data = [], int $statusCode = 200)
    {
        return json_encode([
            'message' => $message,
            'data' => $data,
            'status_code' => $statusCode
        ], true);
    }

    static function errorResponseJson(string $message, int $statusCode = 400)
    {
        return json_encode([
            'message' => $message,
            'status_code' => $statusCode
        ], true);
    }
}


?>