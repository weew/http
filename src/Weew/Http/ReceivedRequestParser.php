<?php

namespace Weew\Http;

use Weew\Url\Url;

class ReceivedRequestParser implements IReceivedRequestParser {
    /**
     * @param array $server
     * @param IHttpRequest $request
     *
     * @return IHttpRequest
     */
    public function parseRequest(array $server, IHttpRequest $request = null) {
        if ( ! $request instanceof IHttpRequest) {
            $request = $this->createRequest();
        }

        $this->setMethod($request, $server);
        $this->setUrl($request, $server);
        $this->setHeaders($request, $server);
        $this->setProtocol($request, $server);
        $this->setContent($request);

        return $request;
    }

    /**
     * @param array $server
     *
     * @return HttpHeaders
     */
    public function parseHeaders(array $server) {
        return (new ReceivedHeadersParser())->parseHeaders($server);
    }

    /**
     * @param array $server
     *
     * @return mixed
     */
    public function parseMethod(array $server) {
        $method = array_get($server, 'REQUEST_METHOD');

        if (array_has($server, '_method')) {
            $_method = strtoupper(array_get($server, '_method'));

            if (in_array($_method, HttpRequestMethod::getMethods())) {
                return $_method;
            }
        }

        return $method;
    }

    /**
     * @param array $server
     *
     * @return Url
     */
    public function parseUrl(array $server) {
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

        if (array_has($server, 'HTTPS')) {
            $protocol = HttpProtocol::HTTPS;
        }

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

    /**
     * @param IHttpRequest $request
     * @param array $server
     */
    public function setMethod(IHttpRequest $request, array $server) {
        $request->setMethod($this->parseMethod($server));
    }

    /**
     * @param IHttpRequest $request
     * @param array $server
     */
    public function setUrl(IHttpRequest $request, array $server) {
        $request->setUrl($this->parseUrl($server));
    }

    /**
     * @param IHttpRequest $request
     * @param array $server
     */
    public function setHeaders(IHttpRequest $request, array $server) {
        $request->setHeaders($this->parseHeaders($server));
    }

    /**
     * @return HttpRequest
     */
    protected function createRequest() {
        return new HttpRequest();
    }
}
