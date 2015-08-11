<?php

namespace Weew\Http;

interface IReceivedHeadersParser {
    /**
     * @param array $source
     *
     * @return IHttpHeaders
     */
    function parseHeaders(array $source);
}
