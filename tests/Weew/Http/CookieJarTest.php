<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\CookieJar;
use Weew\Http\HttpHeaders;

class CookieJarTest extends PHPUnit_Framework_TestCase {
    public function test_to_array() {
        $jar = new CookieJar(new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;']));

        $this->assertEquals(
            ['foo' => 'bar', 'yolo' => 'swag', 'bar' => 'foo'], $jar->toArray()
        );
    }

    public function test_find_by_name() {
        $jar = new CookieJar(new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;']));

        $this->assertEquals('bar', $jar->get('foo'));
        $this->assertEquals('swag', $jar->get('yolo'));
    }

    public function test_add() {
        $jar = new CookieJar(new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;']));
        $jar->set('xx', 'yy');

        $this->assertEquals(
            'yy', $jar->get('xx')
        );
    }
}