<?php

namespace Weew\Http;

interface IExtendable {
    /**
     * @param IHttpResponse $response
     *
     * @return IHttpResponse
     */
    function extend(IHttpResponse $response);
}
