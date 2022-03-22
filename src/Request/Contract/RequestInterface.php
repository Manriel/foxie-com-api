<?php

namespace Foxie\Request\Contract;

use Foxie\Data\Contract\DataInterface;

/**
 *
 */
interface RequestInterface
{
    /**
     * @param array|null $data
     *
     * @return DataInterface
     */
    public function send(?array $data = null): DataInterface;
}