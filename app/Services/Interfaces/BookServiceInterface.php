<?php

namespace App\Services\Interfaces;

interface BookServiceInterface
{
    public function createBook(array $data): \stdClass|array;

    public function deleteBook(int $id): int|array;

}
