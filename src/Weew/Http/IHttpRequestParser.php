<?php

namespace Weew\Http;

interface IHttpRequestParser {
    /**
     * @return IHttpRequest
     */
    function parse();
}
