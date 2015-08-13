<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpData;
use Weew\Http\HttpDataType;
use Weew\Http\HttpRequest;

class HttpDataTest extends PHPUnit_Framework_TestCase {
    public function test_get_data_encoded() {
        $request = new HttpRequest();
        $data = new HttpData($request);

        $this->assertNull($data->getDataEncoded());

        $request->setContent('foo=bar');
        $this->assertEquals(
            'foo=bar', $data->getDataEncoded()
        );
    }

    public function test_set_data_encoded() {
        $request = new HttpRequest();
        $data = new HttpData($request);
        $data->setDataEncoded('foo=bar');

        $this->assertEquals(
            'foo=bar', $data->getDataEncoded()
        );
    }

    public function test_get_data() {
        $request = new HttpRequest();
        $data = new HttpData($request);
        $request->setContent(http_build_query(['foo' => 'bar']));

        $this->assertEquals(['foo' => 'bar'], $data->getData());
    }

    public function test_set_data() {
        $request = new HttpRequest();
        $data = new HttpData($request);

        $this->assertEquals([], $data->getData());
        $this->assertNotEquals(
            $request->getContent(), $data->getDataType()
        );
        $data->setData(['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $data->getData());
        $this->assertEquals(
            $data->getDataType(), $request->getContentType()
        );
    }

    public function test_has_data() {
        $request = new HttpRequest();
        $data = new HttpData($request);

        $this->assertFalse($data->hasData());
        $data->setData(['foo' => 'bar']);
        $this->assertTrue($data->hasData());
    }

    public function test_create_with_data() {
        $request = new HttpRequest();
        $data = new HttpData($request, ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $data->getData());
    }

    public function test_getters_and_setters() {
        $request = new HttpRequest();
        $data = new HttpData($request, ['foo' => 'bar']);

        $this->assertEquals('bar', $data->get('foo'));
        $this->assertNull($data->get('bar'));
        $data->set('bar', 'foo');
        $this->assertEquals('foo', $data->get('bar'));
        $this->assertEquals(2, $data->count());
        $this->assertFalse($data->has('yolo'));
        $data->set('yolo', 'swag');
        $this->assertTrue($data->has('yolo'));
        $data->remove('yolo');
        $this->assertFalse($data->has('yolo'));
        $data->add(['foo' => 'foo', 'yolo' => 'swag']);
        $this->assertEquals(
            ['foo' => 'foo', 'bar' => 'foo', 'yolo' => 'swag'], $data->getData()
        );
        $this->assertTrue($data->hasData());
        $request->setContent(null);
        $this->assertFalse($data->hasData());
    }

    public function test_data_type() {
        $request = new HttpRequest();
        $data = new HttpData($request);

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
        $this->assertTrue($data->isMultipart());
    }

    public function test_to_string() {
        $request = new HttpRequest();
        $data = new HttpData($request, ['foo' => 'bar']);

        $this->assertEquals('foo=bar', $data->toString());
    }

    public function test_to_array() {
        $request = new HttpRequest();
        $data = new HttpData($request, ['foo' => 'bar']);

        $this->assertEquals(['foo' => 'bar'], $data->toArray());
    }
}
