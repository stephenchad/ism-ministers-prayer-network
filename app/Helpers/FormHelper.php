<?php

if (!function_exists('old_safe')) {
    /**
     * Safely retrieve old input data, converting arrays to strings when needed
     * 
     * @param string $key
     * @param mixed $default
     * @param bool $asString Whether to force array conversion to string
     * @return mixed
     */
    function old_safe($key, $default = null, $asString = false)
    {
        $value = old($key, $default);
        
        // If we want a string and got an array, convert it appropriately
        if ($asString && is_array($value)) {
            // For checkbox arrays, return first value or empty string
            if (isset($value[0])) {
                return $value[0];
            }
            return '';
        }
        
        // For arrays that should remain arrays (like schedules), return as-is
        return $value;
    }
}

if (!function_exists('old_array')) {
    /**
     * Safely retrieve old array input data
     * 
     * @param string $key
     * @param array $default
     * @return array
     */
    function old_array($key, $default = [])
    {
        $value = old($key, $default);
        
        if (!is_array($value)) {
            return is_null($value) ? $default : [$value];
        }
        
        return $value;
    }
}

if (!function_exists('old_string')) {
    /**
     * Safely retrieve old input as string, even if it was an array
     * 
     * @param string $key
     * @param string $default
     * @return string
     */
    function old_string($key, $default = '')
    {
        $value = old($key, $default);
        
        if (is_array($value)) {
            // Return first element if it exists and is scalar, otherwise default
            return isset($value[0]) && is_scalar($value[0]) ? (string) $value[0] : $default;
        }
        
        return is_scalar($value) ? (string) $value : $default;
    }
}