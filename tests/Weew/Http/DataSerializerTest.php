<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Tests\Weew\Http\Stubs\ArrayableItem;
use Weew\Http\DataSerializer;

class DataSerializerTest extends PHPUnit_Framework_TestCase {
    public function test_serialize_invalid_data() {
        $serializer = new DataSerializer();
        $this->assertEquals(1, $serializer->serialize(1));
    }

    public function test_serialize_complex_structures() {
        $serializer = new DataSerializer();
        $data = $serializer->serialize([new ArrayableItem('foo'), new ArrayableItem('bar')]);
        $this->assertEquals([['id' => 'foo'], ['id' => 'bar']], $data);
    }
}
