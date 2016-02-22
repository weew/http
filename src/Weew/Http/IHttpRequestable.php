<?php

namespace Weew\Http;

interface IHttpRequestable {
    /**
     * @return IHttpRequest
     */
    function toHttpRequest();
}
