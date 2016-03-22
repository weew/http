<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\BasicAuthParser;
use Weew\Http\HttpHeaders;

class BasicAuthHeaderParserTest extends PHPUnit_Framework_TestCase {
    public function test_create_token() {
        $parser = new BasicAuthParser();

        $this->assertEquals(
            base64_encode('foo:bar'),
            $parser->createToken('foo', 'bar')
        );
        $this->assertEquals(
            base64_encode('foo:'),
            $parser->createToken('foo', '')
        );
    }

    public function test_parse_token() {
        $parser = new BasicAuthParser();

        $this->assertEquals(
            ['foo', 'bar'],
            $parser->parseToken($parser->createToken('foo', 'bar'))
        );
        $this->assertEquals(
            ['foo', null],
            $parser->parseToken($parser->createToken('foo', ''))
        );
    }

    public function test_create_header() {
        $parser = new BasicAuthParser();

        $this->assertEquals(
            'Basic foo', $parser->createHeader('foo')
        );
    }

    public function test_parse_header() {
        $parser = new BasicAuthParser();

        $this->assertNull($parser->parseHeader('foo'));
        $this->assertEquals(
            'foo', $parser->parseHeader($parser->createHeader('foo'))
        );
    }

    public function test_get_header() {
        $parser = new BasicAuthParser();

        $this->assertEquals(
            'foo', $parser->getHeader(new HttpHeaders(['authorization' => 'foo']))
        );
    }

    public function test_set_header() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $parser->setHeader($headers, 'foo');
        $this->assertEquals('foo', $parser->getHeader($headers));
    }

    public function test_has_basic_auth() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $this->assertFalse($parser->hasBasicAuth($headers));
        $parser->setHeader($headers, 'foo');
        $this->assertFalse($parser->hasBasicAuth($headers));
        $parser->setHeader($headers, $parser->createHeader('foo'));
        $this->assertTrue($parser->hasBasicAuth($headers));
    }

    public function test_get_token() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders(['authorization' => $parser->createHeader('foo')]);

        $this->assertEquals(
            'foo', $parser->getToken($headers)
        );
    }

    public function test_set_token() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $parser->setToken($headers, 'foo');
        $this->assertEquals(
            'foo', $parser->parseHeader($parser->getHeader($headers))
        );
    }

    public function test_get_credentials() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();
        $parser->setToken($headers, $parser->createToken('foo', 'bar'));

        $this->assertEquals(
            ['foo', 'bar'],
            $parser->getCredentials($headers)
        );
    }

    public function test_set_credentials() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $parser->setCredentials($headers, 'foo', 'bar');
        $this->assertEquals(
            ['foo', 'bar'], $parser->getCredentials($headers)
        );
    }

    public function test_get_username() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $parser->setCredentials($headers, 'foo', 'bar');
        $this->assertEquals(
            'foo', $parser->getUsername($headers)
        );
    }

    public function test_get_password() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $parser->setCredentials($headers, 'foo', 'bar');
        $this->assertEquals(
            'bar', $parser->getPassword($headers)
        );
    }

    public function test_set_username() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $parser->setCredentials($headers, 'foo', 'bar');
        $parser->setUsername($headers, 'yolo');
        $this->assertEquals(
            'yolo', $parser->getUsername($headers)
        );
        $this->assertEquals(
            'bar', $parser->getPassword($headers)
        );
    }

    public function test_set_password() {
        $parser = new BasicAuthParser();
        $headers = new HttpHeaders();

        $parser->setCredentials($headers, 'foo', 'bar');
        $parser->setPassword($headers, 'yolo');
        $this->assertEquals(
            'yolo', $parser->getPassword($headers)
        );
        $this->assertEquals(
            'foo', $parser->getUsername($headers)
        );
    }
}
