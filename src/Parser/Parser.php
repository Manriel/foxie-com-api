<?php

namespace Foxie\Parser;

use Foxie\Data\Contract\DataInterface;

class Parser
{
    public static function parse($string): DataInterface
    {
        return json_decode($string, true);
    }
}