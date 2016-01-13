<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\ContentTypeDataMatcher;
use Weew\Http\Data\HttpJsonData;
use Weew\Http\Data\HttpUrlEncodedData;
use Weew\Http\Exceptions\InvalidDataClassException;
use Weew\Http\HttpRequest;

class ContentTypeDataMatcherTest extends PHPUnit_Framework_TestCase {
    public function test_get_and_set_mappings() {
        $matcher = new ContentTypeDataMatcher();
        $this->assertTrue(is_array($matcher->getMappings()));

        $matcher->setMappings([
            'foo' => HttpUrlEncodedData::class,
        ]);
        $this->assertEquals(
            HttpUrlEncodedData::class, array_get($matcher->getMappings(), 'foo')
        );
    }

    public function test_add_mapping() {
        $matcher = new ContentTypeDataMatcher();
        $matcher->setMappings([]);
        $matcher->addMapping('foo', HttpUrlEncodedData::class);
        $matcher->addMapping('bar', HttpUrlEncodedData::class);

        $this->assertEquals([
            'foo' => HttpUrlEncodedData::class,
            'bar' => HttpUrlEncodedData::class,
        ], $matcher->getMappings());
    }

    public function test_add_mappings_checks_interface() {
        $matcher = new ContentTypeDataMatcher();
        $this->setExpectedException(InvalidDataClassException::class);
        $matcher->addMapping('foo', 'bar');
    }

    public function test_create_data_for_content_type() {
        $request = new HttpRequest();
        $matcher = new ContentTypeDataMatcher();
        $data = $matcher->createDataForContentType($request, 'foo');
        $this->assertTrue($data instanceof HttpUrlEncodedData);

        $data = $matcher->createDataForContentType($request, 'application/json');
        $this->assertTrue($data instanceof HttpJsonData);
    }
}
