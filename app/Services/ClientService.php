<?php


namespace App\Services;


use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

class ClientService
{

    public function __construct()
    {

    }

    public function request(string $apiKey, string $endpoint, array $headers = [])
    {
        try {
            $headers['PRIVATE-TOKEN'] = $apiKey;

            $response = Http::acceptJson()
                ->withHeaders($headers)
                ->get($endpoint);

            return $response->json();
        } catch (ConnectionException $e) {
            return ['errorCode' => 500, 'errorMessage' => $e->getMessage()];
        }
    }
}
