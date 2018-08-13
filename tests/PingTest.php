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

    /** @test */
    public function ping()
    {
        $client = $this->createGuzzleClient([
            new Response(200, [
                'info' => 'Similarity Manager with...',
                'statistics' => [
                    'OperationTime' => 3
                ]
            ])
        ]);
        $ximilar = new XimilarApi($client);

        /** @var Response */
        $response = $ximilar->ping();

        $this->assertMatchesSnapshot(serialize($response));
    }
}
