<?php

namespace Tests\Weew\Http;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpStatusCode;

class HttpStatusCodesTest extends PHPUnit_Framework_TestCase {
    public function test_get_status_text() {
        $this->assertEquals('OK', HttpStatusCode::getStatusText(HttpStatusCode::OK));
    }
}
