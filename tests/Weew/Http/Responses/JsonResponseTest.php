<?php

namespace Tests\Weew\Http\Responses;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Mocks\ArrayableItem;
use Tests\Weew\Http\Mocks\JsonableItem;
use Weew\Http\Responses\JsonResponse;

class JsonResponseTest extends PHPUnit_Framework_TestCase {
    public function test_get_and_set_json_content() {
        $request = new JsonResponse();
        $content = ['foo' => 'bar'];
        $request->setJsonContent($content);
        $this->assertEquals(
            json_encode($content), $request->getContent()
        );
        $this->assertEquals(
            $content, $request->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_arrayable_data() {
        $request = new JsonResponse();
        $content = new ArrayableItem(1);
        $request->setJsonContent($content);
        $this->assertEquals(
            'application/json', $request->getContentType()
        );
        $this->assertEquals(
            json_encode($content->toArray()), $request->getContent()
        );
        $this->assertEquals(
            $content->toArray(), $request->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_jsonable_data() {
        $request = new JsonResponse();
        $content = new JsonableItem(1);
        $request->setJsonContent($content);
        $this->assertEquals(
            'application/json', $request->getContentType()
        );
        $this->assertEquals(
            $content->toJson(), $request->getContent()
        );
        $this->assertEquals(
            ['id' => $content->getId()], $request->getJsonContent()
        );
    }
}
