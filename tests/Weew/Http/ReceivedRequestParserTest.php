<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpRequest;
use Weew\Http\IHttpHeaders;
use Weew\Http\IHttpRequest;
use Weew\Http\ReceivedRequestParser;

class ReceivedRequestParserTest extends PHPUnit_Framework_TestCase {
    public function test_get_url() {
        $source['HTTPS'] = true;
        $source['HTTP_HOST'] = 'google.com:9999';
        $source['REQUEST_URI'] = '/foo/bar?bar=foo&foo=bar';

        $parser = new ReceivedRequestParser();
        $url = $parser->getUrl($source);

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
        $parser = new ReceivedRequestParser();
        $this->assertEquals('foo', $parser->getMethod(['REQUEST_METHOD' => 'foo']));
    }

    public function test_get_headers() {
        $parser = new ReceivedRequestParser();

        $this->assertTrue($parser->getHeaders($_SERVER) instanceof IHttpHeaders);
    }

    public function test_set_protocol() {
        $request = new HttpRequest();
        $parser = new ReceivedRequestParser();
        $parser->setProtocol($request, ['SERVER_PROTOCOL' => 'foo/2.2']);

        $this->assertEquals('foo', $request->getProtocol());
        $this->assertEquals('2.2', $request->getProtocolVersion());
    }

    public function test_set_content() {
        $request = new HttpRequest();
        $parser = new ReceivedRequestParser();

        $parser->setContent($request, 'foo');
        $this->assertEquals('foo', $request->getContent());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_parse_request() {
        $parser = new ReceivedRequestParser();
        $request = $parser->parseRequest($_SERVER);
        $this->assertTrue($request instanceof IHttpRequest);
    }

    public function test_get_fake_method() {
        $parser = new ReceivedRequestParser();

        $this->assertEquals(
            'GET', $parser->getMethod(['_method' => 'get'])
        );
        $this->assertEquals(
            'POST', $parser->getMethod(['_method' => 'POST'])
        );
        $this->assertEquals(
            'DELETE',
            $parser->getMethod(['_method' => 'foo', 'REQUEST_METHOD' => 'DELETE'])
        );
    }
}
