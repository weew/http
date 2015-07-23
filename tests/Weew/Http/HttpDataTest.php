<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpData;
use Weew\Http\HttpDataType;

class HttpDataTest extends PHPUnit_Framework_TestCase {
    public function test_getters_and_setters() {
        $data = new HttpData(['foo' => 'bar']);
        $this->assertEquals(
            ['foo' => 'bar'], $data->getAll()
        );
        $this->assertEquals('bar', $data->get('foo'));
        $data->set('foo', 'yolo');
        $this->assertEquals('yolo', $data->get('foo'));
        $data->remove('foo');
        $this->assertNull($data->get('foo'));
        $this->assertEquals('bar', $data->get('foo', 'bar'));
    }

    public function test_set_and_get_data_type() {
        $data = new HttpData();
        $this->assertEquals(HttpDataType::URL_ENCODED, $data->getDataType());
        $this->assertTrue($data->isUrlEncoded());
        $data->setDataType(HttpDataType::MULTI_PART);
        $this->assertTrue($data->isMultipart());
        $this->assertEquals(HttpDataType::MULTI_PART, $data->getDataType());
    }

    public function test_get_data_encoded() {
        $data = new HttpData(['foo' => 'bar']);
        $this->assertEquals(http_build_query(['foo' => 'bar']), $data->getDataEncoded());
        $data->setDataType(HttpDataType::MULTI_PART);
        $this->assertEquals(['foo' => 'bar'], $data->getDataEncoded());
    }

    public function test_count() {
        $data = new HttpData();
        $this->assertEquals(0, $data->count());
        $data->set('foo', 'bar');
        $this->assertEquals(1, $data->count());
    }

    public function test_add() {
        $data = new HttpData(['foo' => 'bar']);
        $data->add(['bar' => 'baz']);

        $this->assertEquals(2, $data->count());
        $this->assertEquals(
            ['foo' => 'bar', 'bar' => 'baz'], $data->getAll()
        );
    }

    public function test_replace() {
        $data = new HttpData(['foo' => 'bar']);
        $data->replace(['yolo' => 'swag']);

        $this->assertEquals(1, $data->count());
        $this->assertEquals(['yolo' => 'swag'], $data->getAll());
    }
}
