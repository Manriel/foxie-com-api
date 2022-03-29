<?php

namespace Foxie\Data;

/**
 * @property string  $id
 * @property integer $to
 * @property integer $from
 * @property string  $body
 * @property float   $balance
 */
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