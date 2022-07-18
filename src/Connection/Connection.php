<?php

namespace Foxie\Connection;

use Foxie\Exception\ConnectionException;

class Connection implements Contract\ConnectionInterface
{
    protected $url = 'https://api.foxie.net';
    protected $credentials;
    
    protected $curlHandler;
    
    public function __construct(Credentials $credentials, array $config = [])
    {
        $this->credentials = $credentials;
        if (isset($config['url']) && strlen($config['url']) > 0) {
            $this->url = $config['url'];
        }
    }
    
    public function __destruct()
    {
        if ($this->curlHandler) {
            curl_close($this->curlHandler);
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
        return $this->request('GET', $endpoint, $data);
    }
    
    public function post(string $endpoint, ?array $data = [])
    {
        return $this->request('POST', $endpoint, $data);
    }
    
    public function request(string $method, string $endpoint, ?array $data = [])
    {
        $curlOptions = [];
        
        if (strtoupper($method) == 'POST') {
            $curlOptions[CURLOPT_URL]        = $this->getRequestURL($endpoint);
            $curlOptions[CURLOPT_POST]       = true;
            $curlOptions[CURLOPT_POSTFIELDS] = $data;
        } else {
            $curlOptions[CURLOPT_URL]     = $this->getRequestURL($endpoint, $data);
            $curlOptions[CURLOPT_HTTPGET] = true;
        }
    
        $handler = $this->getCurlHandler($curlOptions);
        $result  = curl_exec($handler);
        $info    = curl_getinfo($handler);
    
        if ($errorCode = curl_errno($handler)) {
            throw new ConnectionException(curl_error($handler), $errorCode);
        }
        
        return $result;
    }
    
    protected function getCurlHandler($options)
    {
        if ( !$this->curlHandler) {
            $this->curlHandler = curl_init();
        }
    
        curl_setopt_array($this->curlHandler, ($this->getCurlBaseOptions() + $options));
        
        return $this->curlHandler;
    }
    
    protected function getCurlBaseOptions(): array
    {
        return [
            CURLOPT_RETURNTRANSFER => true,
            // CURLOPT_FRESH_CONNECT  => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FAILONERROR    => true,
            CURLOPT_HTTPAUTH       => CURLAUTH_BASIC,
            CURLOPT_HTTPHEADER     => [
                $this->credentials->getAuthHeader(),
            ],
        ];
    }
}