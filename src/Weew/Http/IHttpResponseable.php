<?php

namespace Weew\Http;

interface IHttpResponseable {
    /**
     * @return IHttpResponse
     */
    function toHttpResponse();
}
