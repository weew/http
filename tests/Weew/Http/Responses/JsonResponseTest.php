<?php

namespace Tests\Weew\Http\Responses;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Stubs\ArrayableItem;
use Tests\Weew\Http\Stubs\JsonableItem;
use Weew\Http\Responses\JsonResponse;

class JsonResponseTest extends PHPUnit_Framework_TestCase {
    public function test_get_and_set_json_content() {
        $response = new JsonResponse(null, ['foo' => 'bar']);
        $this->assertEquals(['foo' => 'bar'], $response->getJsonContent());
        $content = ['bar' => 'baz'];
        $response->setJsonContent($content);
        $this->assertEquals(
            json_encode($content), $response->getContent()
        );
        $this->assertEquals(
            $content, $response->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_arrayable_data() {
        $response = new JsonResponse();
        $content = new ArrayableItem(1);
        $this->assertEquals(
            'application/json', $response->getContentType()
        );
        $this->assertNull($response->getJsonContent());
        $response->setJsonContent($content);
        $this->assertEquals(
            json_encode($content->toArray()), $response->getContent()
        );
        $this->assertEquals(
            $content->toArray(), $response->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_jsonable_data() {
        $response = new JsonResponse();
        $content = new JsonableItem(1);
        $response->setJsonContent($content);
        $this->assertEquals(
            'application/json', $response->getContentType()
        );
        $this->assertEquals(
            $content->toJson(), $response->getContent()
        );
        $this->assertEquals(
            ['id' => $content->getId()], $response->getJsonContent()
        );
    }
}
