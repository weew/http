<?php

namespace Weew\Http;

/**
 * Create an IHttpRequest based on the global
 * request data.
 *
 * Class HttpRequestParser
 */
class HttpRequestParser implements IHttpRequestParser {
    /**
     * @return IHttpRequest
     */
    public function parse() {
        // TODO: test
        $request = new HttpRequest();
        $request->setHeaders(new HttpHeaders(getallheaders()));
        $request->setData(new HttpData($_POST));

        return $request;
    }
}
