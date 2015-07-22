<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Mocks\StringableItem;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpRequest;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IHttpHeaders;
use Tests\Weew\Http\Mocks\ArrayableItem;
use Tests\Weew\Http\Mocks\JsonableItem;

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
            $headers->get('foo'),
            $response->getHeaders()->get('foo')
        );

        $this->assertEquals($headers->get('foo'), $response->getHeader('foo'));
        $this->assertEquals('yolo', $response->getHeader('swag', 'yolo'));
        $response->setHeader('swag', 'yolo');
        $this->assertEquals('yolo', $response->getHeader('swag'));
    }

    public function test_get_protocol_and_version() {
        $response = new HttpResponse();
        $this->assertEquals('HTTP', $response->getProtocol());
        $this->assertEquals('1.1', $response->getProtocolVersion());
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
        $this->assertEquals('text/plain', $response->getContentType());
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

    public function test_get_and_set_json_content() {
        $request = new HttpResponse();
        $content = ['foo' => 'bar'];
        $request->setJsonContent($content);
        $this->assertEquals(
            json_encode($content), $request->getContent()
        );
        $this->assertEquals(
            $content, $request->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_arrayable_data() {
        $request = new HttpResponse();
        $content = new ArrayableItem(1);
        $request->setJsonContent($content);
        $this->assertEquals(
            'application/json', $request->getContentType()
        );
        $this->assertEquals(
            json_encode($content->toArray()), $request->getContent()
        );
        $this->assertEquals(
            $content->toArray(), $request->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_jsonable_data() {
        $request = new HttpResponse();
        $content = new JsonableItem(1);
        $request->setJsonContent($content);
        $this->assertEquals(
            'application/json', $request->getContentType()
        );
        $this->assertEquals(
            $content->toJson(), $request->getContent()
        );
        $this->assertEquals(
            ['id' => $content->getId()], $request->getJsonContent()
        );
    }

    public function test_is_ok() {
        $response = new HttpResponse();
        $this->assertTrue($response->isOk());
        $response->setStatusCode(HttpStatusCode::CREATED);
        $this->assertTrue($response->isOk());
        $response->setStatusCode(HttpStatusCode::NOT_FOUND);
        $this->assertFalse($response->isOk());
    }

    public function test_set_stringable_content() {
        $item = new StringableItem();
        $response = new HttpResponse();

        $this->assertFalse($response->hasContent());
        $response->setContent($item);
        $this->assertTrue($response->hasContent());
        $this->assertEquals($item->toString(), $response->getContent());
    }
}
