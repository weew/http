<?php

namespace Weew\Http;

interface IHeadersAware {
    /**
     * @param IHttpHeaders $headers
     */
    function writeHeaders(IHttpHeaders $headers);
}
