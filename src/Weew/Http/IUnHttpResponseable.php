<?php

namespace Weew\Http;

interface IUnHttpResponseable {
    /**
     * @param IHttpResponse $response
     *
     * @return mixed
     */
    static function fromHttpResponse(IHttpResponse $response);
}
