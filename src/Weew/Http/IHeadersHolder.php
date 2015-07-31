<?php

namespace Weew\Http;

interface IHeadersHolder {
    /**
     * @return IHttpHeaders
     */
    function getHeaders();

    /**
     * @param IHttpHeaders $headers
     */
    function setHeaders(IHttpHeaders $headers);

    /**
     * Tell the holder to build its headers.
     */
    function buildHeaders();
}
