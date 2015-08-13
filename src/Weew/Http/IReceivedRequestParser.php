<?php

namespace Weew\Http;

interface IReceivedRequestParser {
    /**
     * @param array $source
     *
     * @return IHttpRequest
     */
    function parseRequest(array $source);
}
