<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SearchHistoricalGateway
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $key;

    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client, string $url, string $host, string $key)
    {
        $this->url    = $url;
        $this->host   = $host;
        $this->key    = $key;
        $this->client = $client;
    }

    public function getHistorical(string $symbol, DateTime $startDate, DateTime $endDate)
    {
        $response = $this->client->request('GET', $this->url, [
            'headers' => [
                'x-rapidapi-host' => $this->host,
                'x-rapidapi-key'  => $this->key
            ],
            'query'   => [
                'frequency' => '1d',
                'filter'    => 'history',
                'period1'   => $startDate->getTimestamp(),
                'period2'   => $endDate->getTimestamp(),
                'symbol'    => $symbol
            ]
        ]);

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            throw new Exception("Error to get the historical");
        }

        $return = $response->getContent();
        if (!$return) {
            throw new Exception("Error to get the historical");
        }

        $returnData = json_decode($return);
        if (!$return) {
            throw new Exception("Error to get the historical");
        }

        return $returnData->prices;
    }
}