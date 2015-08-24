<?php

namespace tests\Weew\Http\Requests;

use PHPUnit_Framework_TestCase;
use Weew\Http\Requests\CurrentRequest;

class CurrentRequestTest extends PHPUnit_Framework_TestCase {
    public function test_create() {
        $request = new CurrentRequest();
    }
}
