<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\Cookie;
use Weew\Http\CookieBuilder;

class CookieBuilderTest extends PHPUnit_Framework_TestCase {
    public function test_build() {
        $builder = new CookieBuilder();
        $cookie = new Cookie('foo', 'bar');
        $cookie->setPath('/foo/bar');
        $cookie->setDomain('foo.bar');
        $cookie->setSecure(true);
        $cookie->setHttpOnly(true);
        $cookie->setMaxAge(60);
        $this->assertEquals(
            s(
                'foo=bar; expires=%s; max-age=%s; path=/foo/bar; domain=foo.bar; secure; httpOnly',
                $cookie->getExpiresDate(), $cookie->getMaxAge()
            ),
            $builder->build($cookie)
        );
    }
}
