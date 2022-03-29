<?php

namespace Foxie\Data;

use Foxie\Exception\TypeCastingException;

abstract class Data implements Contract\DataInterface, \ArrayAccess, \Serializable
{
    /**
     * @var array fields of a data class
     */
    protected $fields = [];
    
    /**
     * @var array actual values of a data class
     */
    protected $attributes = [];
    
    public function __construct(array $data)
    {
        $this->fillAttributes($data);
    }
    
    /**
     * @param array $data
     *
     * @return void
     * @throws TypeCastingException
     */
    protected function fillAttributes(array $data)
    {
        foreach ($this->fields as $field => $type) {
            if (isset($data[$field]) && $data[$field] !== '') {
                $this->attributes[$field] = TypeCaster::castType($data[$field], $type);
            } else {
                $this->attributes[$field] = null;
            }
        }
    }
    
    public function __get($field)
    {
        return $this->attributes[$field] ?? null;
    }
    
    public function __set($field, $value)
    {
        if (isset($this->fields[$field])) {
            $this->attributes[$field] = TypeCaster::typeof($value, $this->fields[$field]) ? $value : TypeCaster::castType($value, $this->fields[$field]);
        }
    }
    
    public function __isset($field)
    {
        return $this->fields[$field];
    }
    
    public function __unset($field)
    {
        $this->__set($field, null);
    }
    
    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return $this->__isset($offset);
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
                'attributes' => $this->attributes,
            ]
        );
    }
    
    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $params = unserialize($data, [self::class]);
        
        $this->attributes = $params['attributes'];
    }
    
    public function __serialize() {
        $this->serialize();
    }
    
    public function __unserialize($data) {
        $this->unserialize($data);
    }
    
    public function toArray(): array
    {
        return $this->attributes;
    }
    
}