<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpRequest;
use Weew\Http\IHttpHeaders;
use Weew\Http\ReceivedRequestParser;

class ReceivedRequestParserTest extends PHPUnit_Framework_TestCase {
    public function test_get_url() {
        $_SERVER['HTTPS'] = true;
        $_SERVER['HTTP_HOST'] = 'google.com:9999';
        $_SERVER['REQUEST_URI'] = '/foo/bar?bar=foo&foo=bar';

        $parser = new ReceivedRequestParser();
        $url = $parser->getUrl();

        $this->assertEquals(
            'https://google.com:9999/foo/bar?bar=foo&foo=bar',
            $url->toString()
        );

        $this->assertEquals(
            ['bar' => 'foo', 'foo' => 'bar'],
            $url->getSegments()->getQuery()->toArray()
        );
    }

    public function test_get_method() {
        $_SERVER['REQUEST_METHOD'] = 'foo';
        $parser = new ReceivedRequestParser();

        $this->assertEquals('foo', $parser->getMethod());
    }

    public function test_get_headers() {
        $parser = new ReceivedRequestParser();

        $this->assertTrue($parser->getHeaders() instanceof IHttpHeaders);
    }

    public function test_set_protocol() {
        $_SERVER['SERVER_PROTOCOL'] = 'foo/2.2';
        $request = new HttpRequest();
        $parser = new ReceivedRequestParser();
        $parser->setProtocol($request);

        $this->assertEquals('foo', $request->getProtocol());
        $this->assertEquals('2.2', $request->getProtocolVersion());
    }

    public function test_set_content() {
        $request = new HttpRequest();
        $parser = new ReceivedRequestParser();

        $parser->setContent($request, 'foo');
        $this->assertEquals('foo', $request->getContent());
    }
}
