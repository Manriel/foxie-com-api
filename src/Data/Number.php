<?php

namespace Foxie\Data;

class Number
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