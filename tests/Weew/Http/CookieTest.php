<?php

namespace tests\Weew\Http;

use Exception;
use PHPUnit_Framework_TestCase;
use Weew\Http\Cookie;

class CookieTest extends PHPUnit_Framework_TestCase {
    private function getCookie() {
        $cookie = new Cookie('foo', 'bar');
        $cookie->setPath('/foo/bar');
        $cookie->setDomain('foo.bar');
        $cookie->setSecure(true);
        $cookie->setHttpOnly(true);

        return $cookie;
    }

    public function test_getters_and_setters() {
        $cookie = new Cookie();
        $this->assertFalse($cookie->hasName());
        $this->assertFalse($cookie->hasValue());
        $cookie->setName('foo');
        $this->assertTrue($cookie->hasName());
        $this->assertEquals('foo', $cookie->getName());
        $cookie->setValue('bar');
        $this->assertTrue($cookie->hasValue());
        $this->assertEquals('bar', $cookie->getValue());
        $this->assertFalse($cookie->hasPath());
        $this->assertEquals('/', $cookie->getPath());
        $cookie->setPath('foo');
        $this->assertTrue($cookie->hasPath());
        $this->assertEquals('foo', $cookie->getPath());
        $this->assertFalse($cookie->hasDomain());
        $cookie->setDomain('bar');
        $this->assertTrue($cookie->hasDomain());
        $this->assertEquals('bar', $cookie->getDomain());
        $this->assertNull($cookie->getExpires());
        $this->assertFalse($cookie->hasMaxAge());
        $cookie->setMaxAge(1);
        $this->assertTrue($cookie->hasMaxAge());
        $this->assertEquals(time() + 1, $cookie->getExpires());
        $this->assertEquals(1, $cookie->getMaxAge());
        $this->assertEquals(time() + 1, $cookie->getExpires());
        $this->assertTrue($cookie->isHttpOnly());
        $cookie->setHttpOnly(false);
        $this->assertFalse($cookie->isHttpOnly());
        $this->assertFalse($cookie->isSecure());
        $cookie->setSecure(true);
        $this->assertTrue($cookie->isSecure());
    }

    public function test_to_array() {
        $cookie = $this->getCookie();
        $cookie->setMaxAge(1);
        $this->assertEquals([
            'name' => 'foo',
            'value' => 'bar',
            'path' => '/foo/bar',
            'domain' => 'foo.bar',
            'expires' => $cookie->getExpiresDate(),
            'max-age' => $cookie->getMaxAge(),
            'secure' => true,
            'httpOnly' => true,
        ], $cookie->toArray());
    }

    public function test_to_string() {
        $cookie = $this->getCookie();
        $cookie->setMaxAge(60);
        $this->assertEquals(
            s(
                'foo=bar; expires=%s; max-age=%s; path=/foo/bar; domain=foo.bar; secure; httpOnly',
                $cookie->getExpiresDate(), $cookie->getMaxAge()
            ),
            $cookie->toString()
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test_send() {
        if ( ! function_exists('xdebug_get_headers')) {
            throw new Exception(
                'Test skipped, missing required function xdebug_get_headers.'
            );
        }

        $cookie = $this->getCookie();
        $cookie->setMaxAge(22);
        $cookie->send();

        $this->assertEquals(
            strtolower('set-cookie: ' . $cookie->toString()),
            strtolower(array_get(xdebug_get_headers(), 0))
        );
    }

    public function test_create_from_string() {
        $cookie = new Cookie('foo', 'bar');
        $cookie->setSecure(true);
        $cookie->setHttpOnly(true);
        $cookie->setMaxAge(time());
        $cookie->setDomain('google.com');
        $cookie->setPath('/foo/bar');

        $this->assertEquals(
            $cookie->toArray(),
            Cookie::createFromString($cookie->toString())->toArray()
        );
    }
}
