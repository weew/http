<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\ServerGlobal;

class ServerGlobalTest extends PHPUnit_Framework_TestCase {
    public function test_it_takes_a_custom_value() {
        $data = ['foo' => 'bar'];
        $global = new ServerGlobal($data);
        $this->assertEquals('bar', $global->get('foo'));
        $global->set('foo.bar', 'baz');
        $this->assertEquals('baz', array_get($data, 'foo.bar'));
    }

    public function test_it_uses_the_server_global_as_default_value() {
        $_SERVER['foo'] = 'bar';
        $global = new ServerGlobal();
        $this->assertEquals('bar', $global->get('foo'));
        $global->set('foo.bar', 'baz');
        $this->assertEquals('baz', array_get($_SERVER, 'foo.bar'));
    }
}
