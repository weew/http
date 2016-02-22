<?php

namespace Weew\Http;

interface IHttpRequestHolder {
    /**
     * @return IHttpRequest
     */
    function getHttpRequest();
}
