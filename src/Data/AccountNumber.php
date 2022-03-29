<?php

namespace Foxie\Data;

/**
 * @property integer   $smsNumber
 * @property \DateTime $purchased
 * @property string    $campaign
 */
class AccountNumber extends Data
{
    protected $fields = [
        'smsNumber' => 'integer',
        'purchased' => \DateTime::class,
        'campaign'  => 'string',
    ];
}