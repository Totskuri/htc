<?php

namespace App\Manager;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PRHInterfaceManager
{
    private const BASE_URL = 'https://avoindata.prh.fi/';
    private const BIS_V1_URL = 'bis/v1/';

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function getCompanyByBusinessID(string $id): array
    {
        $endpointUrl = self::BIS_V1_URL . $id;
        $response = $this->executeGetRequest($endpointUrl)->toArray();
        return $response['results'] ?? [];
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function executeGetRequest($endpointUrl): ResponseInterface
    {
        $client = HttpClient::create();
        return $client->request('GET', self::BASE_URL . $endpointUrl);
    }
}