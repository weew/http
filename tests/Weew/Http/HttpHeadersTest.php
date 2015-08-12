<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpHeaders;

class HttpHeadersTest extends PHPUnit_Framework_TestCase {
    public function test_getters_and_setters() {
        $headers = new HttpHeaders();
        $headers->add('yolo', 'swag');
        $headers->set('yolo', 'bar');
        $headers->add('bar', 'foo');
        $headers->add('bar', 'baz');

        $this->assertEquals(['bar'], $headers->get('yolo'));
        $this->assertEquals('bar', $headers->find('yolo'));
        $this->assertEquals('baz', $headers->find('bar'));
        $this->assertEquals(['foo', 'baz'], $headers->get('bar'));
        $this->assertTrue($headers->has('yolo'));
        $this->assertTrue($headers->has('bar'));
        $this->assertFalse($headers->has('foo'));
        $headers->add('yolo', 'yolo');
        $this->assertEquals(['bar', 'yolo'], $headers->get('yolo'));
        $this->assertEquals('yolo', $headers->find('yolo'));
        $headers->remove('yolo');
        $this->assertEquals([], $headers->get('yolo'));
        $this->assertEquals('aa', $headers->find('bb', 'aa'));
    }

    public function test_format_key() {
        $headers = new HttpHeaders();
        $this->assertEquals('foo', $headers->formatKey('FOO'));
    }

    public function test_case_insensitive() {
        $headers = new HttpHeaders();
        $headers->set('FOO', 'bar');
        $this->assertTrue($headers->has('fOO'));
        $this->assertEquals('bar', $headers->find('fOO'));
        $this->assertEquals(
            ['foo' => 'bar'], $headers->toDistinctArray()
        );
    }

    public function test_format_header() {
        $headers = new HttpHeaders();
        $this->assertEquals(
            'foo: bar',
            $headers->formatHeader('foo', 'bar')
        );
    }

    private function getHeaders() {
        $headers = new HttpHeaders();
        $headers->add('foo', 'bar');
        $headers->add('foo', 'foo');
        $headers->set('bar', 'foo');

        return $headers;
    }

    public function test_to_array() {
        $headers = $this->getHeaders();
        $this->assertEquals(
            ['foo' => ['bar', 'foo'], 'bar' => ['foo']],
            $headers->toArray()
        );
    }

    public function test_to_distinct_array() {
        $headers = $this->getHeaders();
        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'foo'],
            $headers->toDistinctArray()
        );
    }

    public function test_to_flat_array() {
        $headers = $this->getHeaders();
        $this->assertEquals(
            ['foo: bar', 'foo: foo', 'bar: foo'],
            $headers->toFlatArray()
        );
    }

    public function test_construct() {
        $headers = new HttpHeaders(['foo' => 'bar', 'bar' => ['foo', 'baz']]);
        $this->assertEquals(['foo' => ['bar'], 'bar' => ['foo', 'baz']], $headers->toArray());
    }
}
