<?php

namespace Weew\Http\Requests;

use Weew\Http\Data\JsonData;
use Weew\Http\HttpRequest;

class JsonRequest extends HttpRequest {
    /**
     * @return JsonData
     */
    protected function createData() {
        return new JsonData($this);
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
