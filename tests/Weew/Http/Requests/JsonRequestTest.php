<?php

namespace Tests\Weew\Http\Requests;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Stubs\ArrayableItem;
use Weew\Http\Data\JsonData;
use Weew\Http\Requests\JsonRequest;

class JsonRequestTest extends PHPUnit_Framework_TestCase {
    public function test_uses_json_data() {
        $request = new JsonRequest();
        $this->assertTrue($request->getData() instanceof JsonData);
    }

    public function test_content_type_and_accept_header() {
        $request = new JsonRequest();
        $this->assertEquals(
            'application/json', $request->getContentType()
        );
        $this->assertEquals(
            'application/json', $request->getAccept()
        );
    }

    public function test_writes_content() {
        $request = new JsonRequest();
        $request->getData()->setData(['foo' => 'bar']);
        $this->assertEquals(json_encode(['foo' => 'bar']), $request->getContent());
    }

    public function test_reads_writes() {
        $request = new JsonRequest();
        $request->setContent(json_encode(['foo' => 'bar']));
        $this->assertEquals('bar', $request->getData()->get('foo'));
    }

    public function test_set_complex_content() {
        $response = new JsonRequest();
        $response->setContent([new ArrayableItem('foo'), new ArrayableItem('bar')]);
        $this->assertEquals([['id' => 'foo'], ['id' => 'bar']], $response->getData()->toArray());
    }
}
