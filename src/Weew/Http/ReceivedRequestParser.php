<?php

namespace Weew\Http;

use Weew\Url\Url;

class ReceivedRequestParser implements IReceivedRequestParser {
    /**
     * @param array $source
     *
     * @return IHttpRequest
     */
    public function parseRequest(array $source = null) {
        if ($source === null) {
            $source = $_SERVER;
        }

        $headers = $this->getHeaders($source);
        $method = $this->getMethod($source);
        $url = $this->getUrl($source);

        $request = new HttpRequest($method, $url, $headers);

        $this->setProtocol($request, $source);
        $this->setContent($request);

        return $request;
    }

    /**
     * @param array $source
     *
     * @return HttpHeaders
     */
    public function getHeaders(array $source) {
        return (new ReceivedHeadersParser())->parseHeaders($source);
    }

    /**
     * @param array $source
     *
     * @return mixed
     */
    public function getMethod(array $source) {
        return array_get($source, 'REQUEST_METHOD');
    }

    /**
     * @param array $source
     *
     * @return Url
     */
    public function getUrl(array $source) {
        $protocol = array_has($source, 'HTTPS') ? 'https' : 'http';
        $host = array_get($source, 'HTTP_HOST');
        $uri = array_get($source, 'REQUEST_URI');

        return new Url(s('%s://%s%s', $protocol, $host, $uri));
    }

    /**
     * @param IHttpRequest $request
     * @param array $source
     */
    public function setProtocol(IHttpRequest $request, array $source) {
        $parts = explode('/', array_get($source, 'SERVER_PROTOCOL'));
        $protocol = array_get($parts, 0, $request->getProtocol());
        $version = array_get($parts, 1, $request->getProtocolVersion());

        $request->setProtocol($protocol);
        $request->setProtocolVersion($version);
    }

    /**
     * @param IHttpRequest $request
     * @param null $content
     */
    public function setContent(IHttpRequest $request, $content = null) {
        if ($content === null) {
            $content = file_get_contents('php://input');
        }

        $request->setContent($content);
    }
}
