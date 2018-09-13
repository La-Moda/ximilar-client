<?php

namespace Lamoda\Ximilar;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Lamoda\Ximilar\Options\AllRecords;
use Lamoda\Ximilar\Options\BaseOptions;

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
     * Dets all records stored in the collection (or just their IDs).
     * The answer is either returned as a standard answer,
     * or stored into a file in the local file system, or both.
     * The created file contains each record on a separate line
     * (it can be directly used to bulk insert data into a new index).
     * 
     * @var AllRecords options
     */
    public function allRecords(AllRecords $options)
    {
        $options = $this->preparedOptions($options);

        return $this->client->post('allRecords', $options);
    }

    /**
     * Inserts given list of records (images + metadata) into the index
     * 
     * @var BaseOptions options
     */
    public function insert(BaseOptions $options)
    {
        $options = $this->preparedOptions($options);

        return $this->client->post('insert', $options);
    }

    /**
     * Deletes given list of records (identified by _id) from the index
     * 
     * @var BaseOptions options
     */
    public function delete(BaseOptions $options)
    {
        $options = $this->preparedOptions($options);

        return $this->client->post('delete', $options);
    }

    protected function preparedOptions($options)
    {
        $requestOptions = [];

        foreach ($options as $key => $value) {
            if ($value !== null) {
                $requestOptions[$key] = $value;
            }
        }

        return [
            RequestOptions::JSON => $requestOptions,
        ];
    }
}
