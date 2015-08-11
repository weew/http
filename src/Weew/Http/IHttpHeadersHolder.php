<?php

namespace Weew\Http;

interface IHttpHeadersHolder {
    /**
     * @return IHttpHeaders
     */
    function getHeaders();

    /**
     * @param IHttpHeaders $headers
     */
    function setHeaders(IHttpHeaders $headers);
}
