<?php

namespace Foxie\Data;

use \DateTime;
use \DateTimeInterface;
use Foxie\Exception\TypeCastingException;

/**
 * Type caster for
 */
class TypeCaster
{
    /**
     * @param string $value
     * @param string $type
     *
     * @return mixed
     * @throws TypeCastingException
     */
    public static function castType(string $value, string $type = 'string')
    {
        if (class_exists($type, true)) {
            return self::castObject($value, $type);
        }
        
        return self::castScalar($value, $type);
    }
    
    /**
     * @param string $value
     * @param string $type
     *
     * @return DateTime|false
     * @throws TypeCastingException
     */
    public static function castObject(string $value, string $type = 'string')
    {
        switch ($type) {
            case DateTime::class:
                return DateTime::createFromFormat(DateTimeInterface::RFC3339_EXTENDED, $value);
            default:
                throw new TypeCastingException(sprintf('Uncastable type %s', $type));
        }
    }
    
    /**
     * @param string $value
     * @param string $type
     *
     * @return float|int|string
     */
    public static function castScalar(string $value, string $type = 'string')
    {
        $type = self::normalizeType($type);
        switch ($type) {
            case 'null':
                return null;
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return filter_var($value, FILTER_VALIDATE_INT);
            case 'double':
                return filter_var($value, FILTER_VALIDATE_FLOAT);
            case 'string':
            default:
                return (string)$value;
        }
    }
    
    public static function typeof($value, $type): bool
    {
        $type = self::normalizeType($type);
        
        $detectedType = gettype($value);
        
        if ('object' == $detectedType) {
            $detectedType = get_class($value);
        }
        
        return ($detectedType == $type);
    }
    
    protected static function normalizeType($type)
    {
        switch (strtolower($type)) {
            case 'null':
                return 'null';
            case 'bool':
            case 'boolean':
                return 'boolean';
            case 'int':
            case 'integer':
                return 'integer';
            case 'real':
            case 'float':
            case 'double':
                return 'double';
            case 'str':
            case 'string':
                return 'string';
            default:
                return $type;
        }
    }
}