<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\Cookie;
use Weew\Http\Cookies;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpRequest;

class CookiesTest extends PHPUnit_Framework_TestCase {
    public function test_getters_and_setters() {
        $request = new HttpRequest();
        $cookies = new Cookies($request);
        $cookie = new Cookie('foo', 'bar');
        $this->assertEquals(0, count($cookies->toArray()));
        $this->assertNull($cookies->findByName('foo'));
        $cookies->add($cookie);
        $this->assertEquals(1, count($cookies->toArray()));
        $this->assertNotNull($cookies->findByName('foo'));
        $this->assertTrue($cookie === $cookies->findByName('foo'));
        $cookies->add(new Cookie('yolo', 'swag'));
        $this->assertEquals(2, count($cookies->toArray()));
        $cookies->removeByName('bar');
        $this->assertEquals(2, count($cookies->toArray()));
        $cookies->removeByName('yolo');
        $this->assertEquals(1, count($cookies->toArray()));
        $this->assertEquals(
            $cookie->toString(), $request->getHeaders()->find('set-cookie')
        );
    }

    public function test_clone() {
        $cookies = new Cookies(new HttpRequest());
        $cookie = new Cookie('foo', 'bar');
        $cookies->add($cookie);
        $cookies = clone($cookies);

        $this->assertEquals(
            'bar', $cookies->findByName('foo')->getValue()
        );
        $this->assertFalse(
            $cookies->findByName('foo') === $cookie
        );
    }

    public function test_search_cookies_in_headers() {
        $request = new HttpRequest();
        $cookies = new Cookies($request);
        $cookies->add(new Cookie('foo', 'bar'));
        $cookies->add(new Cookie('bar', 'baz'));

        $cookies = new Cookies($request);
        $this->assertNotNull($cookies->findByName('foo'));
        $this->assertEquals('bar', $cookies->findByName('foo')->getValue());
        $this->assertNotNull($cookies->findByName('bar'));
        $this->assertEquals('baz', $cookies->findByName('bar')->getValue());
    }
}
