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

        $protocol = $this->getProtocolAndStatus($response);
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
    public function getProtocolAndStatus(IHttpResponse $response) {
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
     * @param $key
     * @param $path
     *
     * @return string
     */
    public function getHeader(IHttpResponse $response, $key, $path) {
        return s('%s: %s', $key, $response->getHeaders()->get($path));
    }

    /**
     * @param IHttpResponse $response
     *
     * @return array
     */
    public function getHeaders(IHttpResponse $response) {
        $headers = $response->getHeaders()->getAll(false);
        $httpHeaders = [];

        foreach ($headers as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $k => $v) {
                    $httpHeaders[] = $this->getHeader($response, $key, s('%s.%s', $key, $k));
                }
            } else {
                $httpHeaders[] = $this->getHeader($response, $key, $key);
            }
        }

        return $httpHeaders;
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
