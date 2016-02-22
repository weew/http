<?php

namespace Weew\Http;

interface IHttpResponseHolder {
    /**
     * @return IHttpResponse
     */
    function getHttpResponse();
}
