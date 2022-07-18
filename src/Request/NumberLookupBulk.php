<?php

namespace Foxie\Request;

use Foxie\Data\Contract\DataInterface;
use Foxie\Data\Enqueued;

class NumberLookupBulk extends Request
{
    const TYPE_FILE = 'file';
    const TYPE_DATA = 'data';
    
    protected $requiredFields = [
        'numbers',
        'callbackURL',
        'callbackMethod',
        'callbackDataType',
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
        return '/numberlookup/bulk';
    }
    
    /**
     * @inheritDoc
     */
    protected function getResult($result): DataInterface
    {
        return new Enqueued($result['result']);
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