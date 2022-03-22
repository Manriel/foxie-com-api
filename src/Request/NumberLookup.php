<?php

namespace Foxie\Request;

use Foxie\Data\Collection;
use Foxie\Data\Contract\DataInterface;
use Foxie\Data\Number;

class NumberLookup extends Request
{
    protected $requiredFields = [
        'numbers'
    ];
    
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
        return '/numberlookup';
    }
    
    /**
     * @inheritDoc
     */
    protected function getResult($result): DataInterface
    {
        $collection = new Collection();
        foreach ($result['result'] as $number => $item) {
            $item['number']      = $number;
            $collection[$number] = new Number($item);
        }
        return $collection;
    }
    
    /**
     * @inheritDoc
     */
    public function transformData(?array $data): ?array
    {
        if (isset($data['numbers']) && is_array($data['numbers'])) {
            $data['numbers'] = implode(',', $data['numbers']);
        }
        return $data;
    }
}