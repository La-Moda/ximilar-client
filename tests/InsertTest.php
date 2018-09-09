<?php

namespace Tests;

use GuzzleHttp\Psr7\Response;
use Lamoda\Ximilar\Options\BaseOptions;
use Lamoda\Ximilar\XimilarApi;
use Spatie\Snapshots\MatchesSnapshots;

class InsertTest extends AbstractTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function records_inserted()
    {
        $client = $this->createGuzzleClient([
            new Response(210, [], null, '1.1', 'records inserted'),
        ]);
        $ximilar = new XimilarApi($client);

        $options = new BaseOptions;
        $options->records = [
            [
                '_id' => 321,
                '_url' => 'http://example.com/myimage321.png',
            ],
            [
                '_id' => 322,
                '_url' => 'http://example.com/myimage322.png',
            ],
        ];

        /** @var Response */
        $response = $ximilar->insert($options);

        $this->assertMatchesSnapshot(serialize($response));
    }

    /** @test */
    public function some_records_inserted()
    {
        $client = $this->createGuzzleClient([
            new Response(210, [], null, '1.1', 'records inserted'),
            new Response(211, [], null, '1.1', 'some records inserted')
        ]);
        $ximilar = new XimilarApi($client);

        $options = new BaseOptions;
        $options->records = [
            [
                '_id' => 321,
                '_url' => 'http://example.com/myimage321.png',
            ],
            [
                '_id' => 322,
                '_url' => 'http://example.com/myimage322.png',
            ],
        ];

        /** insert records for test */
        $ximilar->insert($options);

        $options->records = [
            [
                '_id' => 321,
                '_url' => 'http://example.com/myimage321.png',
            ],
            [
                '_id' => 323,
                '_url' => 'http://example.com/myimage323.png',
            ],
        ];
        /** @var Response */
        $response = $ximilar->insert($options);

        $this->assertMatchesSnapshot(serialize($response));
    }

    /** @test */
    public function record_duplicate()
    {
        $client = $this->createGuzzleClient([
            new Response(210, [], null, '1.1', 'records inserted'),
            new Response(411, [], null, '1.1', 'record duplicate')
        ]);
        $ximilar = new XimilarApi($client);

        $options = new BaseOptions;
        $options->records = [
            [
                '_id' => 321,
                '_url' => 'http://example.com/myimage321.png',
            ],
            [
                '_id' => 322,
                '_url' => 'http://example.com/myimage322.png',
            ],
        ];

        $ximilar->insert($options);

        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );

        /** @var Response */
        $response = $ximilar->insert($options);
    }

    /** @test */
    public function hard_capacity_exceeded()
    {
        $client = $this->createGuzzleClient([
            new Response(412, [], null, '1.1', 'hard capacity exceeded')
        ]);
        $ximilar = new XimilarApi($client);

        // Stop here and mark this test as incomplete.
        // TODO: how to test this - Records refused because of storage capacity exceeded
        $this->markTestIncomplete(
            'Records refused because of storage capacity exceeded - This test has not been implemented yet.'
        );
    }
}
