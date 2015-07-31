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
     * @var IHttpBasicAuth
     */
    protected $basicAuth;

    /**
     * @param string $method
     * @param null|IUrl $url
     * @param IHttpHeaders $headers
     * @param IHttpData $data
     */
    public function __construct(
        $method = HttpRequestMethod::GET,
        IUrl $url = null,
        IHttpHeaders $headers = null,
        IHttpData $data = null
    ) {
        if ( ! $headers instanceof IHttpHeaders) {
            $headers = $this->createHeaders();
        }

        if ( ! $url instanceof IUrl) {
            $url = $this->createUrl();
        }

        if ( ! $data instanceof IHttpData) {
            $data = $this->createData();
        }

        $this->setMethod($method);
        $this->setHeaders($headers);
        $this->setUrl($url);
        $this->setData($data);
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
     * Use this as hook to extend your custom request.
     */
    protected function setDefaults() {}

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
     * @return HttpHeaders
     */
    protected function createHeaders() {
        return new HttpHeaders();
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
     * @return string
     * @see HttpRequestMethods
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * @return IUrl
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * @return IUrl
     */
    protected function createUrl() {
        return new Url();
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
        return $this->getHeaders()->find('Accept');
    }

    /**
     * @param string $accept
     */
    public function setAccept($accept) {
        $this->getHeaders()->set('Accept', $accept);
    }

    /**
     * Get default accept header.
     *
     * @return string
     */
    protected function setDefaultAccept() {}

    /**
     * @return string
     */
    public function getContentType() {
        return $this->getHeaders()->find('Content-Type');
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType) {
        $this->getHeaders()->set('Content-Type', $contentType);
    }

    /**
     * @return string
     */
    protected function setDefaultContentType() {}

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
     * @return HttpData
     */
    protected function createData() {
        return new HttpData();
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
     * @return HttpBasicAuth
     */
    protected function createBasicAuth() {
        return new HttpBasicAuth();
    }

    /**
     * Tell headers holder to build its headers.
     */
    public function buildHeaders() {
        $this->getBasicAuth()->writeHeaders($this->getHeaders());
    }

    /**
     * @return array
     */
    public function toArray() {
        $this->buildHeaders();

        return [
            'method' => $this->getMethod(),
            'url' => $this->getUrl()->toString(),
            'headers' => $this->getHeaders()->toArray(),
            'data' => $this->getData()->toArray(),
            'content' => $this->getContent(),
        ];
    }
}
