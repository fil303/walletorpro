<?php

namespace App\Types;

/**
 * ResponseType Class
 * 
 * @template T
 * @template V
 */
class ResponseType
{
    /**
     * Construct method will store all response data
     * 
     * @param bool $status
     * @param string $message
     * @param array<T, V> $data
     */
    public function __construct(
        public bool $status,
        public string $message,
        public array $data
    ){}
}
