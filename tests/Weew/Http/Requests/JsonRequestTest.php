<?php

namespace Tests\Weew\Http\Requests;

use PHPUnit_Framework_TestCase;
use Weew\Http\Requests\JsonRequest;
use Tests\Weew\Http\Mocks\ArrayableItem;
use Tests\Weew\Http\Mocks\JsonableItem;

class JsonRequestTest extends PHPUnit_Framework_TestCase {
    public function test_content_type_and_accept_header() {
        $request = new JsonRequest();
        $this->assertEquals(
            'application/json', $request->getContentType()
        );
        $this->assertEquals(
            'application/json', $request->getAccept()
        );
    }

    public function test_get_and_set_json_content() {
        $request = new JsonRequest();
        $content = ['foo' => 'bar'];
        $request->setJsonContent($content);
        $this->assertEquals(
            json_encode($content), $request->getContent()
        );
        $this->assertEquals(
            $content, $request->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_jsonable_data() {
        $request = new JsonRequest();
        $content = new JsonableItem(1);
        $request->setJsonContent($content);
        $this->assertEquals(
            $content->toJson(), $request->getContent()
        );
        $this->assertEquals(
            ['id' => $content->getId()], $request->getJsonContent()
        );
    }

    public function test_get_and_set_json_content_with_arrayable_data() {
        $request = new JsonRequest();
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
}
