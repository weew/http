<?php

namespace Tests\Weew\Http\Responses;

use PHPUnit_Framework_TestCase;
use Weew\Http\Data\JsonData;
use Weew\Http\Responses\JsonResponse;

class JsonResponseTest extends PHPUnit_Framework_TestCase {
    public function test_uses_json_data() {
        $response = new JsonResponse();
        $this->assertTrue($response->getData() instanceof JsonData);
    }

    public function test_content_type() {
        $response = new JsonResponse(null, ['foo' => 'bar']);
        $this->assertEquals('application/json', $response->getContentType());
        $response->setContentType('foo');
        $response->getData()->set('yolo', 'swag');
        $this->assertEquals('application/json', $response->getContentType());
    }

    public function test_writes_content() {
        $response = new JsonResponse(null, ['foo' => 'bar']);
        $this->assertEquals(json_encode(['foo' => 'bar']), $response->getContent());
        $response->getData()->setData(['bar' => 'baz']);
        $this->assertEquals(json_encode(['bar' => 'baz']), $response->getContent());
    }

    public function test_reads_content() {
        $response = new JsonResponse();
        $response->setContent(json_encode(['foo' => 'bar']));
        $this->assertEquals('bar', $response->getData()->get('foo'));
    }
}
