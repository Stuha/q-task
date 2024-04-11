<?php

namespace App\Services;

use App\Services\Interfaces\AuthorServiceInterface;
use App\Services\Interfaces\ClientServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;


class AuthorService implements AuthorServiceInterface
{
    public function __construct(
        private readonly ClientServiceInterface $clientService)
    {
    }

    public function getAuthorsDataByPage(string $page = '1'): \stdClass|array
    {
        return $this->clientService->get('https://symfony-skeleton.q-tests.com/api/v2/authors?page='.$page);

    }

    public function getAllAuthors(): array
    {
        $authorsData = $this->getAuthorsDataByPage();

        if (is_array($authorsData)) {
            return $authorsData;
        }

        $authors = $authorsData->items;

        for ($pageNumber = 2; $pageNumber <= $authorsData->total_pages; $pageNumber++) {
            $authorsDataMerge = $this->getAuthorsDataByPage((string)$pageNumber);
            $authors = array_merge($authors, $authorsDataMerge->items);
        }

        return $authors;
    }

    public function getAuthors(array $authors): Collection
    {
        $authors = collect($authors);

        return $authors->map(function ($author) {
            return [
                'id' => $author->id,
                'name' => $author->first_name . ' ' . $author->last_name,
                'birthday' => Carbon::parse($author->birthday)->format('d-m-Y'),
            ];
        });
    }

    public function getAuthor(int $id): \stdClass|array
    {
        return $this->clientService->get('https://symfony-skeleton.q-tests.com/api/v2/authors/' . $id);
    }

    public function deleteAuthor(int $id): int|array
    {
        return $this->clientService->delete('https://symfony-skeleton.q-tests.com/api/v2/authors/' . $id);
    }
}
