<?php

use Weew\Http\Cookie;
use Weew\Http\HttpRequest;
use Weew\Http\HttpRequestMethod;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\Responses\HtmlResponse;
use Weew\Http\Responses\JsonResponse;
use Weew\Url\Url;

require 'vendor/autoload.php';

$request = new HttpRequest(HttpRequestMethod::POST, new Url('http://google.com'));
$request = 2;


$response = new HttpResponse();
$response->getQueuedCookies()->add(new Cookie('foo', 'bar'));
$response->send();

////echo json_encode($_SERVER);
//$parser = new \Weew\Http\ReceivedRequestParser();
//$request = $parser->parseRequest();
//
//echo json_encode($request->toArray());
