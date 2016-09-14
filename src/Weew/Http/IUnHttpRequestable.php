<?php

namespace Weew\Http;

interface IUnHttpRequestable {
    /**
     * @param IHttpRequest $request
     *
     * @return mixed
     */
    static function fromHttpRequest(IHttpRequest $request);
}
