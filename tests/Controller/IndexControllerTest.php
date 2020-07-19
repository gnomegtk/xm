<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexPost()
    {
        $client = static::createClient();

        $client->request('POST', '/',
            [
                'companySymbol' => 'AAIT',
                'startDate'     => '2020-07-01',
                'endDate'       => '2020-07-02',
                'email'         => 'a@a.com',
            ]
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}