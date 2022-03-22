<?php

namespace Foxie\Request;

use Foxie\Data\Contract\DataInterface;
use Foxie\Data\Message;

class Messages extends Request
{
    protected $requiredFields = [
        'to',
        'from',
        'body',
    ];
    
    /**
     * @inheritDoc
     */
    protected function getMethod(): string
    {
        return 'POST';
    }
    
    /**
     * @inheritDoc
     */
    protected function getEndpoint(): string
    {
        return '/messages';
    }
    
    /**
     * @inheritDoc
     */
    protected function getResult($result): DataInterface
    {
        return new Message($result['result']);
    }
}