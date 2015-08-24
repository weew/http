# HTTP layer for PHP

[![Build Status](https://travis-ci.org/weew/php-http.svg?branch=master)](https://travis-ci.org/weew/php-http)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/weew/php-http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/weew/php-http/?branch=master)
[![Coverage Status](https://coveralls.io/repos/weew/php-http/badge.svg?branch=master&service=github)](https://coveralls.io/github/weew/php-http?branch=master)
[![License](https://poser.pugx.org/weew/php-http/license)](https://packagist.org/packages/weew/php-http)

## Related Projects

[URL](https://github.com/weew/php-url): used throughout the project.

[HTTP Client](https://github.com/weew/php-http-client): a simple http client that allows
you to send and receive the standardized HttpRequest and HttpResponse objects.

## Installation

`composer require weew/php-http`

## Response

#### Basic response

```php
$response = new HttpResponse();
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
```

#### Content and content type

```php
$response = new HttpResponse();
$response->setContent('<h1>Hello World!</h1>');
$response->setContentType('text/html');
$response->send();
```
```
HTTP/1.1 200 OK
Host: localhost
Connection: close
content-type: text/html

<h1>Hello World!</h1>
```

#### Status codes

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

#### Custom headers

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

#### HtmlResponse

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

#### JsonResponse

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

#### BasicAuthResponse

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

#### Attaching Cookies

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

## Request

#### Creating a simple request

It is very easy to build a custom request.

```php
$request = new HttpRequest(
    HttpRequestMethod::POST,
    new Url('http://example.com')
);
$request->setContent('foo=bar');
```

#### Working with GET data

```php
$request = new HttpRequest();
$request->getUrl()->getQuery()->set('foo', 'bar');

echo $request->getUrl()->getQuery();
// foo=bar
```

#### Working with POST data

```php
$request = new HttpRequest();
$request->getData()->set('foo', 'bar');
$request->getData()->set('bar', 'foo');

echo $request->getContent();
// foo=bar&bar=foo
```

#### Custom headers

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

#### Current Request

Sometimes it is nice to have an object that would represent the current
received http request.

```php
$request = new CurrentRequest();
var_dump($request->toArray());
// all the data that the server received from the client
```

#### Basic Authentication

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
