<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Lamoda\Ximilar\XimilarApi;
use Spatie\Snapshots\MatchesSnapshots;

class PingTest extends AbstractTestCase
{
    use MatchesSnapshots;

    /**
     * XimilarApi
     */
    protected $ximilar;

    /**
     * Setup the test environment.
     */
    protected function setUp()
    {
        parent::setUp();

        $client = $this->createGuzzleClient();

        $this->ximilar = new XimilarApi($client);
    }

    /** @test */
    public function ping()
    {
        /** @var Response */
        $response = $this->ximilar->ping();

        // Q: co myslicie o takich snapshotach? nie wiem czy jest przezreczyste co konkretnie sprawdza test ?
        $this->assertMatchesSnapshot(serialize($response));

        // $this->assertEquals(200, $response->getStatusCode());

        // $this->assertEquals('OK', $response->getReasonPhrase());
    }

    /**
     * Example of answer:
     * {
     *    "info" : "Similarity Manager with...
     *    "statistics" : {
     *       "OperationTime" : 3
     *    },
     *    "status" : {
     *       "text" : "OK",
     *       "code" : 200
     *    }
     * }
     * 
     * @return Client
     */
    protected function createGuzzleClient()
    {
        $mock = new MockHandler([
            new Response(200, [
                'info' => 'Similarity Manager with...',
                'statistics' => [
                    'OperationTime' => 3
                ]
            ]),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }
}
