<?php

namespace App\Provider\FinanceAds\Infrastructure\Repository;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardExternalApiRepository
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchCards(): array
    {
        $url = 'https://tools.financeads.net/webservice.php?wf=1&format=xml&calc=kreditkarterechner&country=ES';
        $response = $this->httpClient->request('GET', $url);

        if ($response->getStatusCode() !== 200) {
            throw new \Exception('Error al obtener los datos de la API.');
        }

        $xml = simplexml_load_string($response->getContent());

        if (!$xml) {
            throw new \Exception('Error al parsear el XML.');
        }

        return $xml->product;
    }
}
