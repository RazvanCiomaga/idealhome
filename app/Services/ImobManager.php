<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ImobManager
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.imobmanager.url');
        $this->apiKey = config('services.imobmanager.key');
    }

    /**
     * Authenticate with the external API and get a token.
     *
     * @return string
     * @throws \Exception
     */
    protected function authenticate(): string
    {
        // Make authentication request
        $response = Http::withHeaders([
            'Accept' => 'application/json', // Adjust if the API requires a different type
        ])->get("{$this->baseUrl}/authenticate?api_key={$this->apiKey}");


        if ($response->successful()) {
            return $response->json('token');
        }

        throw new \Exception("Failed to authenticate with ImobManager: {$response->body()}");
    }

    /**
     * Make a GET request to the external API.
     *
     * @param string $endpoint
     * @param array $params
     * @return array
     * @throws ConnectionException
     * @throws \Exception
     */
    public function get(string $endpoint, array $params = []): array
    {
        $token = $this->authenticate();

        $response = Http::withToken($token)->get("{$this->baseUrl}/{$endpoint}", $params);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("GET request failed: {$response->body()}");
    }

    /**
     * Make a POST request to the external API.
     *
     * @param string $endpoint
     * @param array $data
     * @return array
     * @throws ConnectionException
     * @throws \Exception
     */
    public function post(string $endpoint, array $data = []): array
    {
        $token = $this->authenticate();

        $response = Http::withToken($token)->post("{$this->baseUrl}/{$endpoint}", $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception("POST request failed: {$response->body()}");
    }
}
