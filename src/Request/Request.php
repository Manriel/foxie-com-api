<?php

namespace Foxie\Request;

use Foxie\Connection\Contract\ConnectionInterface;
use Foxie\Data\Contract\DataInterface;
use Foxie\Exception\ValidationException;
use Foxie\Parser\Parser;
use Foxie\Request\Contract\RequestInterface;

abstract class Request implements RequestInterface
{
    protected $connection;
    
    /**
     * @var array fields that marked as required in API docs
     */
    protected $requiredFields = [];
    
    /**
     * @param ConnectionInterface $connection
     */
    public function __construct(ConnectionInterface $connection)
    {
        $this->connection = $connection;
    }
    
    /**
     * @return string
     */
    abstract protected function getMethod(): string;
    
    /**
     * @return string
     */
    abstract protected function getEndpoint(): string;
    
    /**
     * @param $result
     *
     * @return DataInterface
     */
    abstract protected function getResult($result): DataInterface;
    
    /**
     * @return array
     */
    protected function getRequiredFields(): array
    {
        return $this->requiredFields;
    }
    
    /**
     * @param $data
     *
     * @return void
     */
    protected function validate($data)
    {
        $missingFields = [];
        foreach ($this->getRequiredFields() as $field) {
            if ( !isset($data[$field])) {
                $missingFields[] = $field;
            }
        }
        
        if ( !empty($missingFields)) {
            throw new ValidationException(sprintf('Missing required fields: %s', implode(', ', $missingFields)));
        }
    }
    
    /**
     * @param array|null $data
     *
     * @return array|null
     */
    public function transformData(?array $data): ?array
    {
        return $data;
    }
    
    public function parseResponse($response): ?array
    {
        return Parser::parse($response);
    }
    
    /**
     * @inheritDoc
     */
    public function send(?array $data = null): DataInterface
    {
        $data = $this->transformData($data);
        $this->validate($data);
        
        $response = $this->connection->request($this->getMethod(), $this->getEndpoint(), $data);
        return $this->getResult($this->parseResponse($response));
    }
    
}