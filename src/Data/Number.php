<?php

namespace Foxie\Data;

class Number extends Data
{
    protected $fields = [
        'number'     => 'integer',
        'carrier'    => 'string',
        'carrierID'  => 'string',
        'numberType' => 'string',
        'valid'      => 'bool',
        'country'    => 'string',
    ];
}