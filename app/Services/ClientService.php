<?php

namespace App\Services;

use App\Services\Interfaces\ClientServiceInterface;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;


class ClientService implements ClientServiceInterface
{
    public function __construct(private readonly Client $client)
    {}


    public function login(string $email, string $password): \stdClass|array
    {
        try {
            $response = $this->client->request('POST', 'https://symfony-skeleton.q-tests.com/api/v2/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'email' => $email,
                    'password' => $password
                ]
            ]);
        } catch (GuzzleException $e) {
            return ['auth_failed' => 'Authentication failed. Please try again.'];
        }

        return json_decode($response->getBody()->getContents());
    }

    public function get(string $url): \stdClass|array
    {
        $options['headers'] = [
                'Authorization' => 'Bearer ' . session('token'),
                'Accept'        => 'application/json',
        ];

        try {
            $response = $this->client->get($url, $options);
        } catch (GuzzleException $e) {
            return ['error' => 'Failed to fetch data. Please try again.'];
        }

        return json_decode($response->getBody()->getContents());
    }

    public function post(string $url, array $data): \stdClass|array
    {
        $headers = [
            'Authorization' => 'Bearer ' . session('token'),
            'Accept'        => 'application/json',
        ];

        try {
            $response = $this->client->request('POST', $url, [
                'headers' => $headers,
                'json' => $data
            ]);
        } catch (GuzzleException $e) {
            return ['error' => 'Failed to save item. Please try again.'];
        }

        return json_decode($response->getBody()->getContents());
    }

    public function delete(string $url): int|array
    {
        $options['headers'] = [
            'Authorization' => 'Bearer ' . session('token'),
            'Accept'        => 'application/json',
        ];
        try {
            $response = $this->client->delete($url, $options);
        } catch (GuzzleException $e) {
            return ['error' => 'Deletion failed. Please try again.'];
        }

        return $response->getStatusCode();
    }
}
