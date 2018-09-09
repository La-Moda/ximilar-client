<?php

namespace Tests;

use GuzzleHttp\Psr7\Response;
use Lamoda\Ximilar\XimilarApi;
use Lamoda\Ximilar\Options\BaseOptions;
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

        $options = new BaseOptions;

        $options->records = [
            [
                321,
                'http://example.com/myimage321.png',
            ],
            [
                322,
                'http://example.com/myimage322.png',
            ],
        ];

        /** insert records for delete */
        $ximilar->insert($options);

        $options->records = [
            [
                '_id' => 321,
            ],
            [
                '_id' => 322,
            ],
        ];
        /** @var Response */
        $response = $ximilar->delete($options);

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

        $options = new BaseOptions;
        $options->records = [
            [
                321,
                'http://example.com/myimage321.png',
            ],
            [
                322,
                'http://example.com/myimage322.png',
            ],
        ];

        /** insert records for delete */
        $ximilar->insert($options);

        $options->records = [
            [
                '_id' => 321,
            ],
            [
                '_id' => 323,
            ],
        ];
        /** @var Response */
        $response = $ximilar->delete($options);

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

        $options = new BaseOptions;
        $options->records = [
            [
                '_id' => 321,
            ],
            [
                '_id' => 322,
            ],
        ];
        /** @var Response */
        $response = $ximilar->delete($options);

        $this->assertMatchesSnapshot(serialize($response));
    }
}
