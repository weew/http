<?php

namespace Weew\Http;

use Weew\Url\IUrl;
use Weew\Url\Url;

class HttpRequest implements IHttpRequest {
    /**
     * @var IHttpHeaders
     */
    protected $headers;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var IUrl
     */
    protected $url;

    /**
     * @var mixed
     */
    protected $content;

    /**
     * @var IHttpData
     */
    protected $data;

    /**
     * @var IReceivedCookies
     */
    protected $cookieJar;

    /**
     * @var IHttpBasicAuth
     */
    protected $basicAuth;

    /**
     * @var string
     */
    protected $protocol = HttpProtocol::HTTP;

    /**
     * @var string
     */
    protected $version = HttpProtocol::CURRENT_VERSION;

    /**
     * @param string $method
     * @param null|IUrl $url
     * @param IHttpHeaders $headers
     * @param IReceivedCookies $cookieJar
     */
    public function __construct(
        $method = HttpRequestMethod::GET,
        IUrl $url = null,
        IHttpHeaders $headers = null,
        IReceivedCookies $cookieJar = null
    ) {
        $this->setMethod($method);

        if ( ! $url instanceof IUrl) {
            $url = $this->createUrl();
        }

        $this->setUrl($url);

        if ( ! $headers instanceof IHttpHeaders) {
            $headers = $this->createHeaders();
        }

        $this->setHeaders($headers);

        if ( ! $headers instanceof IReceivedCookies) {
            $cookieJar = $this->createCookieJar();
        }

        $this->setReceivedCookies($cookieJar);

        $this->setData($this->createData());
        $this->setBasicAuth($this->createBasicAuth());

        if ($this->getAccept() === null) {
            $this->setDefaultAccept();
        }

        if ($this->getContentType() === null) {
            $this->setDefaultContentType();
        }

        $this->setDefaults();
    }

    /**
     * @return IHttpHeaders
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @param IHttpHeaders $headers
     */
    public function setHeaders(IHttpHeaders $headers) {
        $this->headers = $headers;
    }

    /**
     * @return IReceivedCookies
     */
    public function getReceivedCookies() {
        return $this->cookieJar;
    }

    /**
     * @param IReceivedCookies $cookieJar
     */
    public function setReceivedCookies(IReceivedCookies $cookieJar) {
        $this->cookieJar = $cookieJar;
    }

    /**
     * Use this as hook to extend your custom request.
     */
    protected function setDefaults() {}

    /**
     * @return HttpHeaders
     */
    protected function createHeaders() {
        return new HttpHeaders();
    }

    /**
     * @return ReceivedCookies
     */
    protected function createCookieJar() {
        return new ReceivedCookies($this->getHeaders());
    }

    /**
     * @return IUrl
     */
    protected function createUrl() {
        return new Url();
    }

    /**
     * @param $method
     *
     * @see HttpRequestMethods
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * Get default accept header.
     *
     * @return string
     */
    protected function setDefaultAccept() {}

    /**
     * @return string
     * @see HttpRequestMethods
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @return string
     */
    protected function setDefaultContentType() {}

    /**
     * @return IUrl
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @return HttpData
     */
    protected function createData() {
        $data = new HttpData($this);

        return $data;
    }

    /**
     * @return HttpBasicAuth
     */
    protected function createBasicAuth() {
        $auth = new HttpBasicAuth($this->getHeaders());

        return $auth;
    }

    /**
     * @param IUrl $url
     */
    public function setUrl(IUrl $url) {
        $this->url = $url;
    }

    /**
     * @param $content
     */
    public function setContent($content) {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * @return bool
     */
    public function hasContent() {
        return $this->content !== null;
    }

    /**
     * @return string
     */
    public function getAccept() {
        return $this->getHeaders()->find('accept');
    }

    /**
     * @param string $accept
     */
    public function setAccept($accept) {
        $this->getHeaders()->set('accept', $accept);
    }

    /**
     * @return string
     */
    public function getContentType() {
        return $this->getHeaders()->find('content-type');
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType) {
        $this->getHeaders()->set('content-type', $contentType);
    }

    /**
     * @return IHttpData
     */
    public function getData() {
        return $this->data;
    }

    /**
     * @param IHttpData $data
     */
    public function setData(IHttpData $data) {
        $this->data = $data;
    }

    /**
     * @return IHttpBasicAuth
     */
    public function getBasicAuth() {
        return $this->basicAuth;
    }

    /**
     * @param IHttpBasicAuth $basicAuth
     */
    public function setBasicAuth(IHttpBasicAuth $basicAuth) {
        $this->basicAuth = $basicAuth;
    }

    /**
     * @return string
     */
    public function getProtocol() {
        return $this->protocol;
    }

    /**
     * @param $protocol
     *
     * @see HttpProtocol
     */
    public function setProtocol($protocol) {
        $this->protocol = $protocol;
    }

    /**
     * @return string
     */
    public function getProtocolVersion() {
        return $this->version;
    }

    /**
     * @param $version
     *
     * @see HttpProtocol
     */
    public function setProtocolVersion($version) {
        $this->version = $version;
    }

    /**
     * @return bool
     */
    public function isSecure() {
        return $this->getProtocol() == HttpProtocol::HTTPS;
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'protocol' => $this->getProtocol(),
            'version' => $this->getProtocolVersion(),
            'method' => $this->getMethod(),
            'url' => $this->getUrl()->toString(),
            'headers' => $this->getHeaders()->toArray(),
            'data' => $this->getData()->toArray(),
            'cookies' => $this->getReceivedCookies()->toArray(),
            'content' => $this->getContent(),
        ];
    }
}
