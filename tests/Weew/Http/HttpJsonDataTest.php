<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpDataType;
use Weew\Http\HttpJsonData;
use Weew\Http\HttpRequest;

class HttpJsonDataTest extends PHPUnit_Framework_TestCase {
    public function test_get_data() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request);

        $this->assertEquals([], $data->getData());
        $request->setContent(json_encode(['foo' => 'bar']));
        $this->assertEquals(['foo' => 'bar'], $data->getData());
    }

    public function test_set_data() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request);

        $this->assertNotEquals($request->getContentType(), $data->getDataType());
        $data->setData(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $data->getData());
        $this->assertEquals($request->getContentType(), $data->getDataType());
    }

    public function test_has_data() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request);

        $this->assertFalse($data->hasData());
        $data->setData(['foo' => 'bar']);
        $this->assertTrue($data->hasData());
    }

    public function test_create_with_data() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request, ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $data->getData());
    }

    public function test_getters_and_setters() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request, ['foo' => 'bar']);

        $this->assertEquals('bar', $data->get('foo'));
        $this->assertNull($data->get('bar'));
        $data->set('bar', 'foo');
        $this->assertEquals('foo', $data->get('bar'));
        $this->assertFalse($data->has('yolo'));
        $data->set('yolo', 'swag');
        $this->assertTrue($data->has('yolo'));
        $data->remove('yolo');
        $this->assertFalse($data->has('yolo'));
        $data->extend(['foo' => 'foo', 'yolo' => 'swag']);
        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'foo', 'yolo' => 'swag'], $data->getData()
        );
        $this->assertTrue($data->hasData());
        $request->setContent(null);
        $this->assertFalse($data->hasData());
    }

    public function test_data_type() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request);

        $this->assertNotEquals(
            $data->getDataType(), $request->getContentType()
        );
        $this->assertEquals(
            HttpDataType::JSON, $data->getDataType()
        );
        $data->setDataType('foo');
        $this->assertEquals('foo', $data->getDataType());
    }

    public function test_to_string() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request, ['foo' => 'bar']);

        $this->assertEquals(json_encode(['foo' => 'bar']), $data->toString());
    }

    public function test_to_array() {
        $request = new HttpRequest();
        $data = new HttpJsonData($request, ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $data->toArray());
    }
}
