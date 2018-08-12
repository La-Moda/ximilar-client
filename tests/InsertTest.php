<?php

namespace Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Lamoda\Ximilar\XimilarApi;
use Spatie\Snapshots\MatchesSnapshots;

class InsertTest extends AbstractTestCase
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
    }

    /** @test */
    public function records_inserted()
    {
        $client = $this->createGuzzleClient(
            $this->createRecordsInsertedClientMock()
        );
        $ximilar = new XimilarApi($client);

        $records = [
            [
                321,
                'http://example.com/myimage321.png',
            ],
            [
                322,
                'http://example.com/myimage322.png',
            ],
        ];

        /** @var Response */
        $response = $ximilar->insert($records);
        $this->assertMatchesSnapshot(serialize($response));
    }

    protected function createRecordsInsertedClientMock()
    {
        $status = 210;
        $headers = [];
        $body = null;
        $version = '1.1';
        $reason = 'records inserted';

        $response = new Response($status, $headers, $body, $version, $reason);

        return new MockHandler([$response]);
    }

    /** @test */
    public function some_records_inserted()
    {
        $client = $this->createGuzzleClient(
            $this->createSomeRecordsInsertedClientMock()
        );
        $ximilar = new XimilarApi($client);

        $records = [
            [
                321,
                'http://example.com/myimage321.png',
            ],
            [
                323,
                'http://example.com/myimage322.png',
            ],
        ];

        /** @var Response */
        $response = $ximilar->insert($records);
        $this->assertMatchesSnapshot(serialize($response));
    }

    protected function createSomeRecordsInsertedClientMock()
    {
        $mock = new MockHandler([
            new Response(
                211, [], null, '1.1', 'some records inserted'
            )
        ]);

        return $mock;
    }

    /** @test */
    public function record_duplicate()
    {
        $client = $this->createGuzzleClient(
            $this->createRecordDuplicateClientMock()
        );
        $ximilar = new XimilarApi($client);

        $records = [
            [
                321,
                'http://example.com/myimage321.png',
            ],
            [
                322,
                'http://example.com/myimage322.png',
            ],
        ];

        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        /** @var Response */
        $response = $ximilar->insert($records);
        $this->assertEquals(411, $response->getStatusCode());
    }

    protected function createRecordDuplicateClientMock()
    {
        $mock = new MockHandler([
            new Response(
                411, [], null, '1.1', 'record duplicate'
            )
        ]);

        return $mock;
    }

    /** @test */
    public function hard_capacity_exceeded()
    {
        $client = $this->createGuzzleClient(
            $this->hardCapacityExceeded()
        );
        $ximilar = new XimilarApi($client);

        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'Records refused because of storage capacity exceeded - This test has not been implemented yet.'
        );
    }

    protected function hardCapacityExceeded()
    {
        $mock = new MockHandler([
            new Response(
                412, [], null, '1.1', 'hard capacity exceeded'
            )
        ]);

        return $mock;
    }

    /**
     * @return Client
     */
    protected function createGuzzleClient($mock)
    {
        // return new Client(['base_uri' => 'https://api.ximilar.com/testlamoda/v2/']);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }
}
