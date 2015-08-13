<?php

namespace Weew\Http;

interface IReceivedRequestParser {
    /**
     * @param array $server
     *
     * @return IHttpRequest
     */
    function parseRequest(array $server);
}
