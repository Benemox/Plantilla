<?php

namespace App\Provider\FinanceAds\Infrastructure\Http;

use App\Provider\FinanceAds\Domain\Exception\ApiFinanceException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CardApiClient
{
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function fetchCards(): array
    {
        $url = 'https://tools.financeads.net/webservice.php?wf=1&format=xml&calc=kreditkarterechner&country=ES';

        try {
            $response = $this->httpClient->request('GET', $url);
            $statusCode = $response->getStatusCode();

            if ($statusCode !== 200) {
                throw ApiFinanceException::fromHttpError($statusCode, $url);
            }

            $xml = simplexml_load_string($response->getContent());

            if (!$xml || !isset($xml->product)) {
                throw ApiFinanceException::fromInvalidResponseFormat($url);
            }

            return array_map(fn($product) => (array)$product, iterator_to_array($xml->product));
        } catch (ApiFinanceException $e) {
            error_log('[API ERROR] ' . $e->getMessage());
            return [];
        } catch (\Exception $e) {
            error_log('[UNEXPECTED ERROR] ' . $e->getMessage());

            return [];
        }
    }
}
