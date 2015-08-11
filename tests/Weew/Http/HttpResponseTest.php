<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Mocks\StringableItem;
use Weew\Http\QueuedCookies;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpProtocol;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IQueuedCookies;
use Weew\Http\IHttpHeaders;

class HttpResponseTest extends PHPUnit_Framework_TestCase {
    public function test_create_new_response() {
        new HttpResponse();
    }

    public function test_set_and_get_status_code() {
        $response = new HttpResponse();

        $this->assertEquals(
            HttpStatusCode::OK, $response->getStatusCode()
        );

        $response->setStatusCode(HttpStatusCode::MOVED_PERMANENTLY);

        $this->assertEquals(
            HttpStatusCode::MOVED_PERMANENTLY, $response->getStatusCode()
        );
    }

    public function test_get_and_set_headers() {
        $response = new HttpResponse();
        $this->assertTrue($response->getHeaders() instanceof IHttpHeaders);

        $headers = new HttpHeaders();
        $headers->set('foo', 'bar');
        $response->setHeaders($headers);
        $this->assertTrue($response->getHeaders() instanceof IHttpHeaders);
        $this->assertEquals(
            $headers->find('foo'),
            $response->getHeaders()->find('foo')
        );

        $this->assertEquals($headers->find('foo'), $response->getHeaders()->find('foo'));
        $this->assertEquals('yolo', $response->getHeaders()->find('swag', 'yolo'));
        $response->getHeaders()->set('swag', 'yolo');
        $this->assertEquals('yolo', $response->getHeaders()->find('swag'));
    }

    public function test_get_protocol_and_version() {
        $response = new HttpResponse();
        $this->assertEquals(HttpProtocol::HTTP, $response->getProtocol());
        $this->assertEquals(HttpProtocol::CURRENT_VERSION, $response->getProtocolVersion());
    }

    public function test_get_status_text() {
        $response = new HttpResponse(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $this->assertEquals(
            HttpStatusCode::getStatusText(HttpStatusCode::INTERNAL_SERVER_ERROR),
            $response->getStatusText()
        );
    }

    public function test_set_and_get_content_type() {
        $response = new HttpResponse();
        $this->assertEquals(null, $response->getContentType());
        $response->setContentType('text/html');
        $this->assertEquals('text/html', $response->getContentType());
    }

    public function test_get_and_set_content() {
        $response = new HttpResponse();
        $this->assertFalse($response->hasContent());
        $response->setContent('foo');
        $this->assertTrue($response->hasContent());
        $this->assertEquals('foo', $response->getContent());
    }

    public function test_is_ok() {
        $response = new HttpResponse();
        $this->assertTrue($response->isOk());
        $response->setStatusCode(HttpStatusCode::CREATED);
        $this->assertTrue($response->isOk());
        $response->setStatusCode(HttpStatusCode::NOT_FOUND);
        $this->assertFalse($response->isOk());
    }

    public function test_is_redirect() {
        $response = new HttpResponse();
        $this->assertFalse($response->isRedirect());
        $response->setStatusCode(HttpStatusCode::PERMANENTLY_REDIRECT);
        $this->assertTrue($response->isRedirect());
    }

    public function test_is_client_error() {
        $response = new HttpResponse();
        $this->assertFalse($response->isClientError());
        $response->setStatusCode(HttpStatusCode::NOT_FOUND);
        $this->assertTrue($response->isClientError());
    }

    public function test_is_server_error() {
        $response = new HttpResponse();
        $this->assertFalse($response->isServerError());
        $response->setStatusCode(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $this->assertTrue($response->isServerError());
    }

    public function test_is_error() {
        $response = new HttpResponse();
        $this->assertFalse($response->isError());
        $response->setStatusCode(HttpStatusCode::NOT_FOUND);
        $this->assertTrue($response->isError());
        $response->setStatusCode(HttpStatusCode::INTERNAL_SERVER_ERROR);
        $this->assertTrue($response->isError());
    }

    public function test_set_stringable_content() {
        $item = new StringableItem();
        $response = new HttpResponse();

        $this->assertFalse($response->hasContent());
        $response->setContent($item);
        $this->assertTrue($response->hasContent());
        $this->assertEquals($item->toString(), $response->getContent());
    }

    public function test_extend() {
        $httpResponse = new HttpResponse(
            HttpStatusCode::NOT_FOUND, 'yolo', new HttpHeaders(['foo-bar' => 'baz'])
        );
        $customResponse = new HttpResponse();
        $customResponse->extend($httpResponse);
        $this->assertEquals(
            $httpResponse->getStatusCode(), $customResponse->getStatusCode()
        );
        $this->assertEquals(
            $httpResponse->getProtocol(), $customResponse->getProtocol()
        );
        $this->assertEquals(
            $httpResponse->getProtocolVersion(), $customResponse->getProtocolVersion()
        );
        $this->assertEquals(
            $httpResponse->getContent(), $customResponse->getContent()
        );
        $this->assertEquals(
            $httpResponse->getContentType(), $customResponse->getContentType()
        );
        $this->assertEquals(
            'baz', $customResponse->getHeaders()->find('foo-bar')
        );
    }

    public function test_create() {
        $httpResponse = new HttpResponse();
        $httpResponse->setContent('foo');
        $httpResponse->setContentType('bar');
        $customResponse = HttpResponse::create($httpResponse);

        $this->assertEquals('foo', $customResponse->getContent());
        $this->assertEquals('bar', $customResponse->getContentType());
    }

    public function test_cookies() {
        $response = new HttpResponse();
        $cookies = new QueuedCookies($response->getHeaders());
        $this->assertTrue($response->getQueuedCookies() instanceof IQueuedCookies);
        $response->setQueuedCookies($cookies);
        $this->assertTrue($cookies === $response->getQueuedCookies());
    }

    public function test_to_array() {
        $response = new HttpResponse(HttpStatusCode::GONE, 'foo', new HttpHeaders(['foo' => 'bar']));

        $this->assertEquals(
            [
                'protocol' => $response->getProtocol(),
                'version' => $response->getProtocolVersion(),
                'statusCode' => $response->getStatusCode(),
                'statusCodeText' => $response->getStatusText(),
                'headers' => $response->getHeaders()->toArray(),
                'content' => $response->getContent(),
            ],
            $response->toArray()
        );
    }
}
