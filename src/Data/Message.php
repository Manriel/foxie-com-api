<?php

namespace Foxie\Data;

class Message extends Data
{
    protected $fields = [
        'id'      => 'string', // UUID
        'to'      => 'integer',
        'from'    => 'integer',
        'body'    => 'string',
        'balance' => 'float',
    ];
    
}