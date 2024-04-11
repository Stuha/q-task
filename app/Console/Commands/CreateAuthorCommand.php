<?php

namespace App\Console\Commands;

use App\Services\Interfaces\ClientServiceInterface;
use Carbon\Carbon;
use Dotenv\Dotenv;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;

class CreateAuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-author';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new author.';


    public function handle(ClientServiceInterface $clientService)
    {
        $path = base_path('.env');
        $dotenv = Dotenv::createUnsafeImmutable(base_path());
        $dotenv->load();
        $token = getenv('VERIFICATION_TOKEN');
        $content = file_get_contents($path);

        if (!$token) {
            $loginCredentials = [
                'email' => $this->ask('Enter your email:'),
                'password' => $this->secret('Enter your password:'),
            ];

            $response = $clientService->login($loginCredentials['email'], $loginCredentials['password']);
            $this->validateResponseData($response, $path, $content);
        } else {
            session(['token' => $token]);
        }

        $authorData = [
            'first_name' => $this->ask('Enter author first name:'),
            'last_name' => $this->ask('Enter author last name:'),
            'birthday' => $this->ask('Enter author birth date (YYYY-MM-DD):'),
            'biography' => $this->ask('Enter author biography:'),
            'gender' => $this->ask('Enter author\'s gender:'),
            'place_of_birth' => $this->ask('Enter author\'s place of birth:'),
        ];

        $authorData['birthday'] = Carbon::parse($authorData['birthday'])->format('Y-m-d\TH:i:s.v\Z');

        $this->saveAuthor($clientService, $authorData, $path, $token, $content);

        $this->info('Author created successfully.');
    }

    public function validateResponseData(array|\stdClass $response, string $path, bool|string $content): void
    {
        if (is_array($response)) {
            $this->error('Invalid credentials.');
        } else {
            $this->info('Logged in successfully.');
            session(['token' => $response->token_key]);

            file_put_contents($path, str_replace(
                'VERIFICATION_TOKEN=', 'VERIFICATION_TOKEN=' . $response->token_key, $content));
        }
    }

    public function saveAuthor(ClientServiceInterface $clientService, array $authorData, string $path, bool|array|string $token, bool|string $content): void
    {
        try {
            $clientService->post('https://symfony-skeleton.q-tests.com/api/v2/authors', $authorData);
        } catch (GuzzleException $e) {
            file_put_contents($path, str_replace(
                'VERIFICATION_TOKEN=' . $token, 'VERIFICATION_TOKEN=', $content));

            $this->error('Authentication failed please try again.');
        }
    }

}
