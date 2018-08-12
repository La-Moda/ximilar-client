<?php

namespace Lamoda\Ximilar;

class Record
{
    /**
     * @var array
     */
    public $value;

    public function __construct($id, $url) {
        $this->value = [
            '_id' => $id,
            '_url' => $url
        ];
    }
}