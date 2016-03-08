<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpRequest;
use Weew\Http\IHttpHeaders;
use Weew\Http\IHttpRequest;
use Weew\Http\ReceivedRequestParser;
use Weew\Http\ServerGlobal;

class ReceivedRequestParserTest extends PHPUnit_Framework_TestCase {
    public function test_parse_url() {
        $source['HTTPS'] = true;
        $source['HTTP_HOST'] = 'google.com:9999';
        $source['REQUEST_URI'] = '/foo/bar?bar=foo&foo=bar';

        $parser = new ReceivedRequestParser();
        $url = $parser->parseUrl($source);

        $this->assertEquals(
            'https://google.com:9999/foo/bar?bar=foo&foo=bar',
            $url->toString()
        );

        $this->assertEquals(
            ['bar' => 'foo', 'foo' => 'bar'],
            $url->getQuery()->toArray()
        );
    }

    public function test_parse_method() {
        $parser = new ReceivedRequestParser();
        $this->assertEquals('foo', $parser->parseMethod(['REQUEST_METHOD' => 'foo']));
    }

    public function test_parse_headers() {
        $parser = new ReceivedRequestParser();

        $this->assertTrue($parser->parseHeaders($_SERVER) instanceof IHttpHeaders);
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

    public function test_set_server_global() {
        $request = new HttpRequest();
        $parser = new ReceivedRequestParser();

        $parser->setServerGlobal($request, ['foo']);
        $this->assertTrue(['foo'] === $request->getServerGlobal()->toArray());
    }

    /**
     * @runInSeparateProcess
     */
    public function test_parse_request() {
        $parser = new ReceivedRequestParser();
        $request = $parser->parseRequest($_SERVER);
        $this->assertTrue($request instanceof IHttpRequest);
    }

    public function test_parse_fake_method() {
        $parser = new ReceivedRequestParser();

        $this->assertEquals(
            'GET', $parser->parseMethod(['_method' => 'get'])
        );
        $this->assertEquals(
            'POST', $parser->parseMethod(['_method' => 'POST'])
        );
        $this->assertEquals(
            'DELETE',
            $parser->parseMethod(['_method' => 'foo', 'REQUEST_METHOD' => 'DELETE'])
        );
    }

    public function test_parse_https_protocol() {
        $parser = new ReceivedRequestParser();
        $_SERVER['HTTPS'] = 'on';
        $request = $parser->parseRequest($_SERVER);
        $this->assertTrue($request->isSecure());
    }
}
