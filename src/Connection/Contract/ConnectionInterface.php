<?php

namespace Foxie\Connection\Contract;

interface ConnectionInterface
{
    public function get(string $endpoint, ?array $data = []);
    
    public function post(string $endpoint, ?array $data = []);
    
    public function request(string $method, string $endpoint, ?array $data = []);
}