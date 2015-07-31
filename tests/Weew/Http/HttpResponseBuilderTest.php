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
}
