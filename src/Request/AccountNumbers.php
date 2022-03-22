<?php

namespace Foxie\Request;

use Foxie\Data\AccountNumber;
use Foxie\Data\Collection;
use Foxie\Data\Contract\DataInterface;

class AccountNumbers extends Request
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
        return '/account/smsnumbers';
    }
    
    /**
     * @inheritDoc
     */
    protected function getResult($result): DataInterface
    {
        $collection = new Collection();
        foreach ($result as $item) {
            $collection[] = new AccountNumber($item);
        }
        return new $collection;
    }
}