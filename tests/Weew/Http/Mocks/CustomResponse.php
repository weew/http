<?php

namespace Tests\Weew\Http\Mocks;

use Weew\Http\HttpResponse;

class CustomResponse extends HttpResponse {
    public function setDefaultContentType() {
        $this->setContentType('foo/bar');
    }

    public function customMethod() {
        return 'foo';
    }
}
