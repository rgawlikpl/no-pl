<?php

namespace Core;

class Request
{
    private array $postData;
    private array $putData = [];

    public function __construct()
    {
        $this->postData = $_POST;
        $this->parsePutData();
    }

    private function parsePutData(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $input = file_get_contents('php://input');
            parse_str($input, $this->putData);
        }
    }

    public function getPostData(string $key = null)
    {
        if ($key === null) {
            return $this->postData;
        }

        return $this->postData[$key] ?? null;
    }

    public function getPutData(string $key = null)
    {
        if ($key === null) {
            return $this->putData;
        }

        return $this->putData[$key] ?? null;
    }
}
