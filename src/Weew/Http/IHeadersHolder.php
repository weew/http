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
     * @param $key
     *
     * @param null $default
     *
     * @return string
     */
    function getHeader($key, $default = null);

    /**
     * @param $key
     * @param $value
     */
    function setHeader($key, $value);

    /**
     * Tell the holder to build its headers.
     */
    function buildHeaders();
}
