# HTTP layer for PHP

[![Build Status](https://img.shields.io/travis/weew/php-http.svg)](https://travis-ci.org/weew/php-http)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-http.svg)](https://scrutinizer-ci.com/g/weew/php-http)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-http.svg)](https://coveralls.io/github/weew/php-http)
[![Dependencies](https://img.shields.io/versioneye/d/php/weew:php-http.svg)](https://www.versioneye.com/php/weew:php-http)
[![Version](https://img.shields.io/packagist/v/weew/php-http.svg)](https://packagist.org/packages/weew/php-http)
[![Licence](https://img.shields.io/packagist/l/weew/php-http.svg)](https://packagist.org/packages/weew/php-http)

## Table of contents

- [Installation](#installation)
- [Responses](#responses)
    - [Basic response](#basic-response)
    - [Content](#content)
    - [Status codes](#status-codes)
    - [Headers](#headers)
    - [Cookies](#cookies)
    - [Custom responses](#custom-responses)
        - [HtmlResponse](#htmlresponse)
        - [JsonResponse](#jsonresponse)
        - [BasicAuthResponse](#basicauthresponse)
- [Requests](#requests)
    - [Basic request](#basic-request)
    - [GET parameters](#get-parameters)
    - [POST data](#post-data)
    - [Headers](#headers)
    - [Current request](#current-request)
    - [Basic authentication](#basic-authentication)
- [Related projects](#related-projects)

## Installation

`composer require weew/php-http`

## Responses

### Basic response

```php
$response = new HttpResponse();
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
```

### Content

```php
$response = new HttpResponse();
$response->setContent('<h1>Hello World!</h1>');
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
content-type: text/html

<h1>Hello World!</h1>
```

### Status codes

```php
$response = new HttpResponse(HttpStatusCode::UNAUTHORIZED);
// or
$response = new HttpResponse(401);
$response->send();
```
```
HTTP/1.1 401 Unauthorized
Host: localhost
Connection: close
```

### Headers

```php
$response = new HttpResponse();
$response->getHeaders()->set('foo', 'bar');
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
foo: bar
```

### Cookies

```php
$response = new HttpResponse();
$response->getQueuedCookies()->add(new Cookie('foo', 'bar'));
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
set-cookie: foo=bar; path=/; httpOnly
```

## Custom responses

### HtmlResponse

```php
$response = new HtmlResponse();
$response->setHtmlContent('<h1>Hello World!</h1>');
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
content-type: text/html

<h1>Hello World!</h1>
```

### JsonResponse

```php
$response = new JsonResponse();
$response->setJsonContent(['Hello' => 'World!']);
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
content-type: application/json

{"Hello":"World!"}
```

### BasicAuthResponse

```php
$response = new BasicAuthResponse('Please login');
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
www-authenticate: basic realm="Please login"
```

## Requests

### Basic request

It is very easy to build a custom request.

```php
$request = new HttpRequest(
    HttpRequestMethod::POST,
    new Url('http://example.com')
);
$request->setContent('foo=bar');
```

### GET parameters

```php
$request = new HttpRequest();
$request->getUrl()->getQuery()->set('foo', 'bar');

echo $request->getUrl()->getQuery();
// foo=bar
```

### POST data

```php
$request = new HttpRequest();
$request->getData()->set('foo', 'bar');
$request->getData()->set('bar', 'foo');

echo $request->getContent();
// foo=bar&bar=foo
```

### Headers

You can access headers the same way as on the `HttpResponse` class.

```php
$request = new HttpRequest();
$request->getHeaders()->set('foo', 'bar');
$request->getHeaders()->add('foo', 'foo');

var_dump($request->getHeaders()->get('foo'));
// ['bar', 'foo']
echo $request->getHeaders()->find('foo');
// foo
```

### Current Request

Sometimes it is nice to have an object that would represent the current
received http request.

```php
$request = new CurrentRequest();
var_dump($request->toArray());
// all the data that the server received from the client
```

### Basic Authentication

It is very easy to authenticate a request via basic auth.

```php
$request = new HttpRequest();
$request->getBasicAuth()->setUsername('foo');
$request->getBasicAuth()->setPassword('bar');
echo $request->getBasicAuth()->getToken();
// Zm9vOmJhcg==
echo $request->getHeaders()->find('authentication');
// Basic Zm9vOmJhcg==
```

## Related Projects

- [URL](https://github.com/weew/php-url): used throughout the project.
- [HTTP Client](https://github.com/weew/php-http-client): a simple http client that allows
you to send and receive the standardized HttpRequest and HttpResponse objects.
