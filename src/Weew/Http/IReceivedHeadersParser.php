<?php

namespace Weew\Http;

interface IReceivedHeadersParser {
    /**
     * @param array $server
     *
     * @return IHttpHeaders
     */
    function parseHeaders(array $server);
}
