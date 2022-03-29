<?php

namespace Foxie\Data;

/**
 * @property integer $number
 * @property string  $carrier
 * @property string  $carrierID
 * @property boolean $valid
 * @property string  $country
 */
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