<?php

namespace Foxie\Connection;

class Credentials
{
    private $username;
    private $password;
    
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }
    
    public function getAuthHeader()
    {
        return 'Authorization: Basic ' . base64_encode($this->username . ':' . $this->password);
    }
}