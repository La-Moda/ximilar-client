<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @return Client
     */
    protected function createGuzzleClient($mock)
    {
        $handler = HandlerStack::create(new MockHandler($mock));

        $client = new Client(['handler' => $handler]);

        return $client;
    }
}
