<?php

namespace Weew\Http;

interface IReceivedRequestParser {
    /**
     * @param array $server
     * @param IHttpRequest $request
     *
     * @return IHttpRequest
     */
    function parseRequest(array $server, IHttpRequest $request = null);
}
