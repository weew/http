<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\SuperGlobal;

class SuperGlobalTest extends PHPUnit_Framework_TestCase {
    public function test_get() {
        $data = ['foo' => ['bar' => 'baz']];
        $global = new SuperGlobal($data);
        $this->assertEquals('baz', $global->get('foo.bar'));
    }

    public function test_get_returns_default_value() {
        $data = ['foo' => ['bar' => 'baz']];
        $global = new SuperGlobal($data);
        $this->assertEquals('baz', $global->get('yolo', 'baz'));
    }

    public function test_set() {
        $data = ['foo' => ['bar' => 'baz']];
        $global = new SuperGlobal($data);
        $global->set('foo.bar', 'yolo');
        $this->assertEquals('yolo', $global->get('foo.bar'));
        $this->assertEquals('yolo', array_get($data, 'foo.bar'));
    }

    public function test_has() {
        $data = ['foo' => ['bar' => 'baz']];
        $global = new SuperGlobal($data);
        $global->set('foo.bar', 'yolo');
        $this->assertTrue($global->has('foo.bar'));
        $this->assertFalse($global->has('yolo'));
    }

    public function test_remove() {
        $data = ['foo' => ['bar' => 'baz']];
        $global = new SuperGlobal($data);
        $global->remove('foo.bar');
        $this->assertNull($global->get('foo.bar'));
        $this->assertNull(array_get($data, 'foo.bar'));
        $this->assertEquals([], $global->get('foo'));
        $this->assertEquals([], array_get($data, 'foo'));
    }

    public function test_to_array() {
        $data = ['foo' => ['bar' => 'baz']];
        $global = new SuperGlobal($data);
        $this->assertEquals($data, $global->toArray());
    }
}
