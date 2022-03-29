<?php

namespace Foxie\Data;

/**
 * @property string $uuid
 * @property string $status
 */
class Enqueued extends Data
{
    protected $fields = [
        'uuid'   => 'string', // UUID
        'status' => 'string',
    ];
}