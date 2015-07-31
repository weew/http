<?php

namespace Weew\Http;

/**
 * Convert an IHttpResponse object to an http response.
 *
 * Class HttpResponseBuilder
 */
class HttpResponseBuilder implements IHttpResponseBuilder {
    /**
     * @param IHttpResponse $response
     */
    public function build(IHttpResponse $response) {
        $response->buildHeaders();
        $this->sendHeaders($response);
        $this->sendContent($response);
    }

    /**
     * @param IHttpResponse $response
     */
    public function sendHeaders(IHttpResponse $response) {
        if (headers_sent()) {
            return;
        }

        $protocol = $this->createRequestDefinition($response);
        $headers = $this->getHeaders($response);

        $this->sendHeader($protocol);

        foreach ($headers as $header) {
            $this->sendHeader($header);
        }
    }

    /**
     * @param IHttpResponse $response
     */
    public function sendContent(IHttpResponse $response) {
        echo $response->getContent();
    }

    /**
     * @param IHttpResponse $response
     *
     * @return string
     */
    public function createRequestDefinition(IHttpResponse $response) {
        return s(
            '%s/%s %d %s',
            $response->getProtocol(),
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getStatusText()
        );
    }

    /**
     * @param IHttpResponse $response
     *
     * @return array
     */
    public function getHeaders(IHttpResponse $response) {
        return $response->getHeaders()->toFlatArray();
    }

    /**
     * @param $header
     */
    public function sendHeader($header) {
        if (headers_sent()) {
            return;
        }

        header($header);
    }
}
