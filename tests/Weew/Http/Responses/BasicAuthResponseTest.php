<?php

namespace tests\Weew\Http\Responses;

use PHPUnit_Framework_TestCase;
use Weew\Http\HttpStatusCode;
use Weew\Http\Responses\BasicAuthResponse;

class BasicAuthResponseTest extends PHPUnit_Framework_TestCase {
    public function test_constructor() {
        $response = new BasicAuthResponse('foo');
        $this->assertEquals(
            HttpStatusCode::UNAUTHORIZED, $response->getStatusCode()
        );
        $this->assertEquals('foo', $response->getRealm());
        $response->setRealm('bar');
        $this->assertEquals('bar', $response->getRealm());
        $this->assertEquals(
            $response->getHeaders()->find('www-authenticate'),
            'Basic realm="bar"'
        );
    }
}
