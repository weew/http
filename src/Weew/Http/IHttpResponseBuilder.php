<?php

namespace Weew\Http;

interface IHttpResponseBuilder {
    /**
     * @param IHttpResponse $response
     */
    function build(IHttpResponse $response);

    /**
     * @param IHttpResponse $response
     */
    function sendHeaders(IHttpResponse $response);

    /**
     * @param IHttpResponse $response
     */
    function sendContent(IHttpResponse $response);
}
