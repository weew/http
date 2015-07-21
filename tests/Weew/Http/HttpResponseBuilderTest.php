<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpResponse;
use Weew\Http\HttpResponseBuilder;
use Weew\Http\HttpStatusCode;

class HttpResponseBuilderTest extends PHPUnit_Framework_TestCase {
    public function test_get_protocol_and_status() {
        $builder = new HttpResponseBuilder();
        $response = new HttpResponse(HttpStatusCode::NOT_FOUND);

        $this->assertEquals(
            s(
                'HTTP/1.1 %d %s',
                HttpStatusCode::NOT_FOUND,
                HttpStatusCode::getStatusText(HttpStatusCode::NOT_FOUND)
            ),
            $builder->getProtocolAndStatus($response)
        );
    }

    public function test_get_header() {
        $builder = new HttpResponseBuilder();
        $response = new HttpResponse();

        $response->getHeaders()->set('foo', 'bar');
        $this->assertEquals('foo: bar', $builder->getHeader($response, 'foo'));
    }

    public function test_get_headers() {
        $builder = new HttpResponseBuilder();
        $response = new HttpResponse();

        $response->getHeaders()->set('foo', 'bar');
        $response->getHeaders()->set('bar', 'foo');
        $headers = $builder->getHeaders($response);

        $this->assertContains('foo: bar', $headers);
        $this->assertContains('bar: foo', $headers);
    }
}
