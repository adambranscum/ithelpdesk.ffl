<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class MicrosoftGraphService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://graph.microsoft.com/v1.0/']);
        $this->token = $this->getAccessToken();
    }

    protected function getAccessToken()
    {
        return Cache::remember('microsoft_graph_token', 3500, function () {
            $tenantId = env('MICROSOFT_TENANT_ID');
            $clientId = env('MICROSOFT_CLIENT_ID');
            $clientSecret = env('MICROSOFT_CLIENT_SECRET');

            if (empty($tenantId) || empty($clientId) || empty($clientSecret)) {
                throw new \Exception('Missing Microsoft Graph credentials. Please check your .env file.');
            }

            $tokenUrl = "https://login.microsoftonline.com/{$tenantId}/oauth2/v2.0/token";

            $response = (new Client())->post($tokenUrl, [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $clientId,
                    'client_secret' => $clientSecret,
                    'scope' => 'https://graph.microsoft.com/.default',
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['access_token'];
        });
    }

    public function getDepartmentLocations()
    {
        $response = $this->client->get('users?$select=department,officeLocation&$top=999', [
            'headers' => [
                'Authorization' => "Bearer {$this->token}",
                'Accept' => 'application/json',
            ],
        ]);

        $users = json_decode($response->getBody(), true)['value'] ?? [];

        return collect($users)
            ->filter(fn($u) => !empty($u['department']) || !empty($u['officeLocation']))
            ->map(fn($u) => [
                'department' => $u['department'] ?? 'N/A',
                'location' => $u['officeLocation'] ?? 'N/A',
            ])
            ->unique()
            ->values();
    }
}

