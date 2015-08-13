<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\CookieParser;

class CookieParserTest extends PHPUnit_Framework_TestCase {
    public function test_parse() {
        $parser = new CookieParser();
        $cookie = $parser->parse('foo=bar;');
        $this->assertFalse($cookie->isSecure());
        $this->assertFalse($cookie->isHttpOnly());
        $this->assertEquals('foo', $cookie->getName());
        $this->assertEquals('bar', $cookie->getValue());
        $this->assertEquals('/', $cookie->getPath());
        $this->assertFalse($cookie->hasMaxAge());
        $this->assertFalse($cookie->hasDomain());

        $cookie = $parser->parse(
            'bad1=; bad2; =bad3; foo=bar; expires=Wed, 23-Mar-2061 18:03:40 GMT; max-age=1439413310; path=/foo/bar; domain=google.com; secure; httpOnly'
        );
        $this->assertTrue($cookie->isSecure());
        $this->assertTrue($cookie->isHttpOnly());
        $this->assertEquals('foo', $cookie->getName());
        $this->assertEquals('bar', $cookie->getValue());
        $this->assertEquals('/foo/bar', $cookie->getPath());
        $this->assertEquals('google.com', $cookie->getDomain());
        $this->assertEquals(1439413310, $cookie->getMaxAge());
    }
}
