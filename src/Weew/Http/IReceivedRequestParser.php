<?php

namespace Weew\Http;

interface IReceivedRequestParser {
    /**
     * @return IHttpRequest
     */
    function parseRequest();
}
