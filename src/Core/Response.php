<?php

namespace Core;

class Response
{
    public const STATUS_OK = 200;
    public const STATUS_CREATED = 201;
    public const STATUS_BAD_REQUEST = 400;
    public const STATUS_NOT_FOUND = 404;

    public function __construct(int $statusCode = self::STATUS_OK, string|null $message = '', array $data = [])
    {
        http_response_code($statusCode);

        if ($message) {
            echo $message."\n";
        }

        if (!empty($data)) {
            print_r($data);
        }
    }
}
