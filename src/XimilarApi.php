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

    /**
     * Returns a basic information about the index
     */
    public function ping()
    {
        return $this->client->get('ping');
    }

    /**
     * Inserts given list of records (images + metadata) into the index
     * 
     * @var array records - a list of records to insert into the index
     * @var array fields_to_return with default value ["_id"]
     */
    public function insert($records, $fields_to_return = ['_id'])
    {
        $options = $this->preparedOptions($records, $fields_to_return);

        return $this->client->post('insert', $options);
    }

    /**
     * Deletes given list of records (identified by _id) from the index
     * 
     * @var array records - a list of records to insert into the index
     * @var array fields_to_return with default value ["_id"]
     */
    public function delete($records, $fields_to_return = ['_id'])
    {
        $options = $this->preparedOptions($records, $fields_to_return);

        return $this->client->post('delete', $options);
    }

    protected function preparedOptions($records, $fields_to_return)
    {
        return [
            RequestOptions::JSON => [
                'records' => $records,
                'fields_to_return' => $fields_to_return,
            ],
        ];
    }
}
