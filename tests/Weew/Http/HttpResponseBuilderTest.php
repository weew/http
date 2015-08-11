<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpProtocol;
use Weew\Http\HttpResponse;
use Weew\Http\HttpResponseBuilder;
use Weew\Http\HttpStatusCode;

class HttpResponseBuilderTest extends PHPUnit_Framework_TestCase {
    public function test_get_protocol_and_status() {
        $builder = new HttpResponseBuilder();
        $response = new HttpResponse(HttpStatusCode::NOT_FOUND);

        $this->assertEquals(
            s(
                '%s/%s %d %s',
                HttpProtocol::HTTP,
                HttpProtocol::CURRENT_VERSION,
                HttpStatusCode::NOT_FOUND,
                HttpStatusCode::getStatusText(HttpStatusCode::NOT_FOUND)
            ),
            $builder->createRequestDefinition($response)
        );
    }

    public function test_get_headers() {
        $builder = new HttpResponseBuilder();
        $response = new HttpResponse();

        $response->getHeaders()->add('foo', 'bar');
        $response->getHeaders()->add('foo', 'foo');
        $response->getHeaders()->set('bar', 'baz');
        $headers = $builder->getHeaders($response);

        $this->assertContains('foo: bar', $headers);
        $this->assertContains('foo: foo', $headers);
        $this->assertContains('bar: baz', $headers);
    }

    public function test_send_content() {
        $builder = new HttpResponseBuilder();
        $response = new HttpResponse(200, 'bar');
        ob_start();
        $builder->sendContent($response);
        $this->assertEquals('bar', ob_get_clean());
    }
}
