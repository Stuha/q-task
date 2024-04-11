<?php

namespace App\Services\Interfaces;

use GuzzleHttp\Exception\GuzzleException;

interface ClientServiceInterface
{
    public function login(string $email, string $password): \stdClass|array;

    public function get(string $url): \stdClass|array;

    public function post(string $url, array $data): \stdClass|array;

    public function delete(string $url): int|array;
}
