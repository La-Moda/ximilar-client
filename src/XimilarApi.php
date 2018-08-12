<?php

namespace Lamoda\Ximilar;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;

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

    /**
     * @var array records - a list of records to insert into the index
     * @var array fields_to_return with default value ["_id"]
     */
    public function insert($records, $fields_to_return = ['_id'])
    {
        $records = $this->transform($records);

        $options = [
            RequestOptions::JSON => [
                'records' => $records,
                'fields_to_return' => $fields_to_return,
            ],
        ];

        return $this->client->post('insert', $options);
    }

    protected function transform($records)
    {
        if (!$records instanceof Collection) {
            $records = collect($records);
        }

        $records->transform(function ($record) {
            $ximilarRecord = new Record(...$record);

            return $ximilarRecord->value;
        });

        return $records;
    }
}
