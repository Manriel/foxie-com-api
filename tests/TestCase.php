<?php

namespace Foxie\Test;

use Foxie\Connection\Contract\ConnectionInterface;
use PHPUnit\Framework\TestCase as PhpUnitTestCase;

class TestCase extends PhpUnitTestCase
{
    
    protected function makeConnection() {
        return $this->createMock(ConnectionInterface::class);
    }
    
}
