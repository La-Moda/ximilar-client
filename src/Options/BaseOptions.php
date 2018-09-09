<?php

namespace Lamoda\Ximilar\Options;

class BaseOptions
{
    /**
     * @var array records - a list of records to insert into the index
     */
    public $records = [];
    
    /**
     * @var array fields_to_return with default value ["_id"]
     */
    public $fields_to_return = ['_id'];
}
