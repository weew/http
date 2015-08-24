<?php

namespace tests\Weew\Http\Responses;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpResponse;
use Weew\Http\Responses\HtmlResponse;

class HtmlResponseTest extends PHPUnit_Framework_TestCase {
    public function test_create() {
        $htmlResponse = HtmlResponse::create(new HttpResponse());
        $this->assertEquals('text/html', $htmlResponse->getContentType());
    }

    public function test_get_and_set_content() {
        $htmlResponse = new HtmlResponse(null, 'yolo');
        $this->assertEquals('yolo', $htmlResponse->getHtmlContent());
        $htmlResponse->setHtmlContent('foo');
        $this->assertEquals('foo', $htmlResponse->getHtmlContent());
    }
}
