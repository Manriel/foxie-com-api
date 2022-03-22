<?php

namespace Foxie\Data;

class Collection implements Contract\DataInterface, \ArrayAccess, \Serializable
{
    protected $data;
    
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }
    
    public function __get($field)
    {
        return $this->data[$field];
    }
    
    public function __set($field, $value)
    {
        $this->data[$field] = $value;
    }
    
    public function __isset($field)
    {
        return isset($this->data[$field]);
    }
    
    public function __unset($field)
    {
        unset($this->data[$field]);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        $this->__isset($offset);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->__set($offset, $value);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        $this->__unset($offset);
    }
    
    /**
     * @inheritDoc
     */
    public function serialize(): ?string
    {
        return serialize(
            [
                'data' => $this->data,
            ]
        );
    }
    
    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $params = unserialize($data, [self::class]);
        
        $this->data = $params['data'];
    }
}