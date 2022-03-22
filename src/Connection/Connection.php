<?php

namespace Foxie\Connection;

use Foxie\Exception\ConnectionException;

class Connection implements Contract\ConnectionInterface
{
    protected $url = 'https://api.foxie.net';
    protected $credentials;
    
    public function __construct(Credentials $credentials, array $config = [])
    {
        $this->credentials = $credentials;
        if (isset($config['url']) && strlen($config['url']) > 0) {
            $this->url = $config['url'];
        }
    }
    
    protected function getRequestUrl(string $endpoint, array $queryParams = []): string
    {
        $result = $this->url . '/' . trim(trim($endpoint), '/');
        if ( !empty($queryParams)) {
            $result .= '?' . http_build_query($queryParams);
        }
        return $result;
    }
    
    public function get(string $endpoint, ?array $data = [])
    {
        $this->request('GET', $endpoint, $data);
    }
    
    public function post(string $endpoint, ?array $data = [])
    {
        $this->request('POST', $endpoint, $data);
    }
    
    public function request(string $method, string $endpoint, ?array $data = [])
    {
        $curlOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER     => [
                $this->credentials->getAuthHeader(),
            ],
        ];
        
        if (strtoupper($method) == 'POST') {
            $curlOptions[CURLOPT_URL]        = $this->getRequestURL($endpoint);
            $curlOptions[CURLOPT_POST]       = true;
            $curlOptions[CURLOPT_POSTFIELDS] = $data;
        } else {
            $curlOptions[CURLOPT_URL]     = $this->getRequestURL($endpoint, $data);
            $curlOptions[CURLOPT_HTTPGET] = true;
        }
        
        $ch = curl_init();
        curl_setopt_array($ch, $curlOptions);
        try {
            $result = curl_exec($ch);
            $info   = curl_getinfo($ch);
            
            if ($errorCode = curl_errno($ch)) {
                throw new ConnectionException(curl_error($ch), $errorCode);
            }
        } finally {
            curl_close($ch);
        }
        
        return $result;
    }
}