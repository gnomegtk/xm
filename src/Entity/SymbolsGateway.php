<?php

declare(strict_types=1);

namespace App\Entity;

use Exception;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SymbolsGateway
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var HttpClientInterface
     */
    private $client;

    /**
     * SymbolsGateway constructor.
     *
     * @param HttpClientInterface $client
     * @param $url
     */
    public function __construct(HttpClientInterface $client, string $url)
    {
        $this->url    = $url;
        $this->client = $client;
    }

    /**
     * @return string[]
     *
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getList()
    {
        $response = $this->client->request('GET', $this->url);

        $statusCode = $response->getStatusCode();
        if ($statusCode != 200) {
            throw new Exception("Error to get the company symbols");
        }

        $return = $response->getContent();
        if (!$return) {
            throw new Exception("Error to get the company symbols");
        }

        $returnData = json_decode($return);
        if (!$return) {
            throw new Exception("Error to get the company symbols");
        }

        $options = ['' => ''];
        foreach ($returnData as $data) {
            $array = (array) $data;

            $options[$array['Company Name']] = $array['Symbol'];
        }

        return $options;
    }
}