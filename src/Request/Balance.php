<?php

namespace Foxie\Request;

use Foxie\Data\Contract\DataInterface;

class Balance extends Request
{
    
    /**
     * @inheritDoc
     */
    protected function getMethod(): string
    {
        return 'GET';
    }
    
    /**
     * @inheritDoc
     */
    protected function getEndpoint(): string
    {
        return '/account/balance';
    }
    
    /**
     * @inheritDoc
     */
    protected function getResult($result): DataInterface
    {
        return new \Foxie\Data\Balance($result);
    }
}