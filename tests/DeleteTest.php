<?php

namespace Tests;

use GuzzleHttp\Psr7\Response;
use Lamoda\Ximilar\XimilarApi;
use Spatie\Snapshots\MatchesSnapshots;

class DeleteTest extends AbstractTestCase
{
    use MatchesSnapshots;

    /** @test */
    public function records_deleted()
    {
        $client = $this->createGuzzleClient([
            new Response(210, [], null, '1.1', 'records inserted'),
            new Response(220, [], null, '1.1', 'records deleted')
        ]);
        $ximilar = new XimilarApi($client);

        /** insert records for delete */
        $ximilar->insert([
            [
                321,
                'http://example.com/myimage321.png',
            ],
            [
                322,
                'http://example.com/myimage322.png',
            ],
        ]);

        /** @var Response */
        $response = $ximilar->delete([
            [
                '_id' => 321,
            ],
            [
                '_id' => 322,
            ],
        ]);

        $this->assertMatchesSnapshot(serialize($response));
    }
    
    /** @test */
    public function some_records_deleted()
    {
        $client = $this->createGuzzleClient([
            new Response(210, [], null, '1.1', 'records inserted'),
            new Response(206, [], null, '1.1', 'some of the records not found')
        ]);
        $ximilar = new XimilarApi($client);

        /** insert records for delete */
        $ximilar->insert([
            [
                321,
                'http://example.com/myimage321.png',
            ],
            [
                322,
                'http://example.com/myimage322.png',
            ],
        ]);

        /** @var Response */
        $response = $ximilar->delete([
            [
                '_id' => 321,
            ],
            [
                '_id' => 323,
            ],
        ]);

        $this->assertMatchesSnapshot(serialize($response));
    }

    /** @test */
    public function records_not_found()
    {
        $client = $this->createGuzzleClient([
            new Response(210, [], null, '1.1', 'records inserted'),
            new Response(404, [], null, '1.1', 'records not found')
        ]);
        $ximilar = new XimilarApi($client);

        /** @var Response */
        $response = $ximilar->delete([
            [
                '_id' => 321,
            ],
            [
                '_id' => 322,
            ],
        ]);

        $this->assertMatchesSnapshot(serialize($response));
    }
}
