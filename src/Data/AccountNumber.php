<?php

namespace Foxie\Data;

class AccountNumber extends Data
{
    protected $fields = [
        'smsNumber' => 'integer',
        'purchased' => \DateTime::class,
        'campaign'  => 'string',
    ];
}