<?php

namespace App\Services\Interfaces;

use Illuminate\Support\Collection;

interface AuthorServiceInterface
{
    public function getAuthorsDataByPage(string $page = '1'): \stdClass|array;

    public function getAllAuthors(): array;

    public function getAuthors(array $authors): Collection;

    public function getAuthor(int $id): \stdClass|array;

    public function deleteAuthor(int $id): int|array;
}
