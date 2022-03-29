<?php

namespace Foxie\Data;

class Collection implements Contract\DataInterface, \ArrayAccess, \Serializable, \Countable
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
    
    public function __set($field, $value): void
    {
        if ($field !== null) {
            $this->data[$field] = $value;
        } else {
            $this->data[] = $value;
        }
    }
    
    public function __isset($field): bool
    {
        return isset($this->data[$field]);
    }
    
    public function __unset($field): void
    {
        unset($this->data[$field]);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetExists($offset): void
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
    public function offsetSet($offset, $value): void
    {
        $this->__set($offset, $value);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
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
    
    public function __serialize() {
        $this->serialize();
    }
    
    public function __unserialize($data) {
        $this->unserialize($data);
    }
    
    public function count(): int
    {
        return count($this->data);
    }
    
    public function toArray(): array
    {
        $result = [];
        foreach ($this->data as $k => $v) {
            if ($k !== null) {
                $result[$k] = $v->toArray();
            } else {
                $result[] = $v->toArray();
            }
        }
        return $result;
    }
}