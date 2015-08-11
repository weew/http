<?php

namespace tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\ReceivedCookies;
use Weew\Http\HttpHeaders;
use Weew\Http\ICookie;

class ReceivedCookiesTest extends PHPUnit_Framework_TestCase {
    public function test_to_array() {
        $jar = new ReceivedCookies(new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;']));

        $this->assertEquals(
            ['foo' => 'bar', 'yolo' => 'swag', 'bar' => 'foo'], $jar->toArray()
        );
    }

    public function test_find_by_name() {
        $jar = new ReceivedCookies(new HttpHeaders(['cookie' => 'foo=bar;yolo=swag; bar=foo;']));

        $this->assertTrue($jar->findByName('foo') instanceof ICookie);
        $this->assertEquals('bar', $jar->findByName('foo')->getValue());
        $this->assertEquals('swag', $jar->findByName('yolo')->getValue());
    }
}
