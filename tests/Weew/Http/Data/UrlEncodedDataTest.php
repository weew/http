<?php

namespace Tests\Weew\Http\Data;

use PHPUnit_Framework_TestCase;
use Weew\Http\Data\UrlEncodedData;
use Weew\Http\HttpDataType;
use Weew\Http\HttpRequest;

class UrlEncodedDataTest extends PHPUnit_Framework_TestCase {
    public function test_get_data() {
        $request = new HttpRequest();
        $data = new UrlEncodedData($request);

        $this->assertEquals([], $data->getData());
        $request->setContent(http_build_query(['foo' => 'bar']));
        $this->assertEquals(['foo' => 'bar'], $data->getData());
    }

    public function test_set_data() {
        $request = new HttpRequest();
        $data = new UrlEncodedData($request);

        $this->assertNotEquals($request->getContentType(), $data->getDataType());
        $data->setData(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $data->getData());
        $this->assertEquals($data->getDataType(), $request->getContentType());
    }

    public function test_has_data() {
        $request = new HttpRequest();
        $data = new UrlEncodedData($request);

        $this->assertFalse($data->hasData());
        $data->setData(['foo' => 'bar']);
        $this->assertTrue($data->hasData());
    }

    public function test_create_with_data() {
        $request = new HttpRequest();
        $data = new UrlEncodedData($request, ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $data->getData());
    }

    public function test_getters_and_setters() {
        $request = new HttpRequest();
        $data = new UrlEncodedData($request, ['foo' => 'bar']);

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
        $data = new UrlEncodedData($request);

        $this->assertNotEquals(
            $data->getDataType(), $request->getContentType()
        );
        $this->assertEquals(
            HttpDataType::URL_ENCODED, $data->getDataType()
        );
        $this->assertTrue($data->isUrlEncoded());
        $this->assertFalse($data->isMultipart());
        $data->setDataType(HttpDataType::MULTI_PART);
        $this->assertEquals(
            HttpDataType::MULTI_PART, $data->getDataType()
        );
        $this->assertTrue($data->isMultipart());
        $this->assertFalse($data->isUrlEncoded());
    }

    public function test_to_string() {
        $request = new HttpRequest();
        $data = new UrlEncodedData($request, ['foo' => 'bar']);

        $this->assertEquals('foo=bar', $data->toString());
    }

    public function test_to_array() {
        $request = new HttpRequest();
        $data = new UrlEncodedData($request, ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $data->toArray());
    }

    public function test_pick() {
        $request = new HttpRequest();
        $data = new UrlEncodedData(
            $request, ['foo' => 'bar', 'bar' => 'baz', 'yolo' => 'swag']
        );

        $this->assertEquals([
            'foo' => 'bar',
            'yolo' => 'swag',
        ], $data->pick(['foo', 'yolo']));
    }
}
