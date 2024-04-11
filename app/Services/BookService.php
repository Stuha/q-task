<?php

namespace App\Services;

use App\Services\Interfaces\ClientServiceInterface;
use Carbon\Carbon;

class BookService implements Interfaces\BookServiceInterface
{
    public function __construct(private readonly ClientServiceInterface $clientService)
    {
    }

    public function createBook(array $data): \stdClass|array
    {
        $createBookData = $this->formatBookData($data);

        return $this->clientService->post('https://symfony-skeleton.q-tests.com/api/v2/books', $createBookData);
    }

    public function deleteBook(int $id): int|array
    {
       return $this->clientService->delete('https://symfony-skeleton.q-tests.com/api/v2/books/' . $id);
    }

    private function formatBookData(array $data): array
    {
        return [
            'author' => ['id' => (int) $data['author_id']],
            'title' => $data['title'],
            'release_date' => Carbon::parse($data['release_date'])->format('Y-m-d\TH:i:s.v\Z'),
            'description' => $data['description'],
            'isbn' => $data['isbn'],
            'format' => $data['format'],
            'number_of_pages' => (int) $data['number_of_pages'],
        ];
    }
}
