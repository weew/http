<?php

namespace Tests\Weew\Http\Responses;

use PHPUnit_Framework_TestCase;
use Weew\Http\Responses\RedirectResponse;
use Weew\Url\Url;

class RedirectResponseTest extends PHPUnit_Framework_TestCase {
    public function test_getters_and_setters() {
        $url = new Url('http://foo.bar');
        $redirect = new RedirectResponse($url);
        $this->assertEquals(
            $url->toString(), $redirect->getDestination()->toString()
        );
    }

    public function test_header_location() {
        $url = new Url('http://foo.bar');
        $redirect = new RedirectResponse($url);
        $this->assertEquals(
            $url->toString(), $redirect->getHeaders()->find('Location')
        );
    }
}
