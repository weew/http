# HTTP layer for PHP

[![Build Status](https://travis-ci.org/weew/php-http.svg?branch=master)](https://travis-ci.org/weew/php-http)
[![Code Climate](https://codeclimate.com/github/weew/php-http/badges/gpa.svg)](https://codeclimate.com/github/weew/php-http)
[![License](https://poser.pugx.org/weew/php-http/license)](https://packagist.org/packages/weew/php-http)

## Motivation

PHP deserves a solid http layer that doesn't suck. I've evaluated some of the existing open source solutions out there and realised that that there is basically no solid abstraction for the whole Request / Response interaction. Well, there is one - Symfony's HttpFoundation. To be true, I don't think that the code is pretty and the implementation versatile and abstract enough. So I've decided to give it a try and create a better http abstraction layer that would be lightweight and sophisticated. Did I succeed? - it's up to you. Right now, I'm pretty happy with the result.

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

---

Work in progress
