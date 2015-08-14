<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\CookieJar;
use Weew\Http\HttpHeaders;
use Weew\Http\HttpRequest;

class CookieJarTest extends PHPUnit_Framework_TestCase {
    public function test_to_array() {
        $request = new HttpRequest(
            null, null, new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;'])
        );
        $jar = new CookieJar($request);

        $this->assertEquals(
            ['foo' => 'bar', 'yolo' => 'swag', 'bar' => 'foo'], $jar->toArray()
        );
    }

    public function test_find_by_name() {
        $request = new HttpRequest(
            null, null, new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;'])
        );
        $jar = new CookieJar($request);

        $this->assertEquals('bar', $jar->get('foo'));
        $this->assertEquals('swag', $jar->get('yolo'));
    }

    public function test_add() {
        $headers = new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;']);
        $request = new HttpRequest(
            null, null, $headers
        );
        $jar = new CookieJar($request);
        $jar->set('xx', 'yy');

        $this->assertEquals(1, count($headers->get('cookie')));
        $this->assertEquals(
            'yy', $jar->get('xx')
        );
        $this->assertEquals(1, count($headers->get('cookie')));
    }
}
