# HTTP layer for PHP

[![Build Status](https://travis-ci.org/weew/php-http.svg?branch=master)](https://travis-ci.org/weew/php-http)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/weew/php-http/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/weew/php-http/?branch=master)
[![Coverage Status](https://coveralls.io/repos/weew/php-http/badge.svg?branch=master&service=github)](https://coveralls.io/github/weew/php-http?branch=master)
[![License](https://poser.pugx.org/weew/php-http/license)](https://packagist.org/packages/weew/php-http)

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

## Request

#### HttpClient

Take a look at the [http-client](https://github.com/weew/php-http-client) for further info.
