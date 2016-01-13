<?php

namespace Weew\Http\Requests;

use Weew\Http\Data\HttpJsonData;
use Weew\Http\HttpRequest;

class JsonRequest extends HttpRequest {
    /**
     * @return HttpJsonData
     */
    protected function createData() {
        return new HttpJsonData($this);
    }

    /**
     * Set accept.
     */
    protected function setDefaultAccept() {
        $this->setAccept('application/json');
    }

    /**
     * Set content type.
     */
    protected function setDefaultContentType() {
        $this->setContentType('application/json');
    }
}
