<?php

namespace Weew\Http;

use Weew\Url\Url;

class ReceivedRequestParser implements IReceivedRequestParser {
    /**
     * @param array $server
     *
     * @return IHttpRequest
     */
    public function parseRequest(array $server) {
        $headers = $this->getHeaders($server);
        $method = $this->getMethod($server);
        $url = $this->getUrl($server);

        $request = new HttpRequest($method, $url, $headers);

        $this->setProtocol($request, $server);
        $this->setContent($request);

        return $request;
    }

    /**
     * @param array $server
     *
     * @return HttpHeaders
     */
    public function getHeaders(array $server) {
        return (new ReceivedHeadersParser())->parseHeaders($server);
    }

    /**
     * @param array $server
     *
     * @return mixed
     */
    public function getMethod(array $server) {
        return array_get($server, 'REQUEST_METHOD');
    }

    /**
     * @param array $server
     *
     * @return Url
     */
    public function getUrl(array $server) {
        $protocol = array_has($server, 'HTTPS') ? 'https' : 'http';
        $host = array_get($server, 'HTTP_HOST');
        $uri = array_get($server, 'REQUEST_URI');

        return new Url(s('%s://%s%s', $protocol, $host, $uri));
    }

    /**
     * @param IHttpRequest $request
     * @param array $server
     */
    public function setProtocol(IHttpRequest $request, array $server) {
        $parts = explode('/', array_get($server, 'SERVER_PROTOCOL'));
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
