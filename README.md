# Foxie.com API Library

This is standalone library, provides php implementation to interact with foxie.com messaging API.

[Api Documentation](https://apidocs.foxie.net/)

## Usage

1. Create Credentials and Connection classes
```php
$credentials = new Foxie\Connection\Credentials($username, $password);
$connection  = new Foxie\Connection\Connection($credentials);
```

2. Make Request class and pass connection to it's constructor argument, then call ``send()`` method 
with argument of array, that contain required and optional parameters of the request, based on 
[Api Documentation](https://apidocs.foxie.net/). 
```php
$request  = new Foxie\Request\Balance($connection);
$response = $request->send([]);
```

3. The response will contain Data class with result of your request.
```php
echo $response->balance; // 0.0
```
