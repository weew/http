<?php

namespace Weew\Http;

use Weew\Url\Url;

class ReceivedRequestParser implements IReceivedRequestParser {
    /**
     * @return IHttpRequest
     */
    public function parseRequest() {
        $headers = $this->getHeaders();
        $method = $this->getMethod();
        $url = $this->getUrl();

        $request = new HttpRequest($method, $url, $headers);

        $this->setProtocol($request);
        $this->setContent($request);

        return $request;
    }

    /**
     * @return HttpHeaders
     */
    public function getHeaders() {
        return (new ReceivedHeadersParser())->parseHeaders();
    }

    /**
     * @return mixed
     */
    public function getMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return Url
     */
    public function getUrl() {
        $protocol = isset($_SERVER['HTTPS']) ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];

        return new Url(s('%s://%s%s', $protocol, $host, $uri));
    }

    /**
     * @param IHttpRequest $request
     */
    public function setProtocol(IHttpRequest $request) {
        $parts = explode('/', $_SERVER['SERVER_PROTOCOL']);
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
