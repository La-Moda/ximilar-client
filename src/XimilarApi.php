<?php

namespace Lamoda\Ximilar;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;

class XimilarApi
{
    /**
     * @var String
     */
    private $api_url = '';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function ping()
    {
        return $this->client->get('ping');
    }
}
