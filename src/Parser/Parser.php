<?php

namespace Foxie\Parser;

class Parser
{
    public static function parse($string): ?array
    {
        return json_decode($string, true);
    }
}