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
     * @var IContentTypeDataMatcher
     */
    protected $contentTypeDataMatcher;

    /**
     * @var ICookieJar
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
     * @var ISuperGlobal
     */
    protected $serverGlobal;

    /**
     * @param string $method
     * @param null|IUrl $url
     * @param IHttpHeaders $headers
     */
    public function __construct(
        $method = HttpRequestMethod::GET,
        IUrl $url = null,
        IHttpHeaders $headers = null
    ) {
        if ( ! $url instanceof IUrl) {
            $url = $this->createUrl();
        }

        if ( ! $headers instanceof IHttpHeaders) {
            $headers = $this->createHeaders();
        }

        $this->setUrl($url);
        $this->setMethod($method);
        $this->setHeaders($headers);
        $this->setCookieJar($this->createCookieJar());
        $this->setBasicAuth($this->createBasicAuth());
        $this->setContentTypeDataMatcher($this->createContentTypeDataMatcher());
        $this->setServerGlobal($this->createServerGlobal());

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
     * @return ICookieJar
     */
    public function getCookieJar() {
        return $this->cookieJar;
    }

    /**
     * @param ICookieJar $cookieJar
     */
    public function setCookieJar(ICookieJar $cookieJar) {
        $this->cookieJar = $cookieJar;
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
     * @param IUrl $url
     */
    public function setUrl(IUrl $url) {
        $this->url = $url;
    }

    /**
     * @param $content
     */
    public function setContent($content) {
        if (is_array($content) || is_object($content)) {
            $this->getData()->setData($content);
        } else {
            $this->content = (string) $content;
        }
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
        if ( ! $this->data instanceof IHttpData) {
            $this->setData($this->createData());
        }

        return $this->data;
    }

    /**
     * @param IHttpData $data
     */
    public function setData(IHttpData $data) {
        $this->data = $data;
    }

    /**
     * @return IContentTypeDataMatcher
     */
    public function getContentTypeDataMatcher() {
        return $this->contentTypeDataMatcher;
    }

    /**
     * @param IContentTypeDataMatcher $contentTypeDataMatcher
     */
    public function setContentTypeDataMatcher(
        IContentTypeDataMatcher $contentTypeDataMatcher
    ) {
        $this->contentTypeDataMatcher = $contentTypeDataMatcher;
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
     * @return ISuperGlobal
     */
    public function getServerGlobal() {
        return $this->serverGlobal;
    }

    /**
     * @param ISuperGlobal $serverGlobal
     */
    public function setServerGlobal(ISuperGlobal $serverGlobal) {
        $this->serverGlobal = $serverGlobal;
    }

    /**
     * Retrieve a value from url query or message body.
     *
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function getParameter($key, $default = null) {
        $value = $this->getUrl()->getQuery()->get($key);

        if ($value === null) {
            $value = $this->getData()->get($key, $default);
        }

        return $value;
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
            'query' => $this->getUrl()->getQuery()->toArray(),
            'cookies' => $this->getCookieJar()->toArray(),
            'content' => $this->getContent(),
        ];
    }

    /**
     * Use this as hook to extend your custom request.
     */
    protected function setDefaults() {
        if ($this->getAccept() === null) {
            $this->setDefaultAccept();
        }

        if ($this->getContentType() === null) {
            $this->setDefaultContentType();
        }
    }

    /**
     * @return HttpHeaders
     */
    protected function createHeaders() {
        return new HttpHeaders();
    }

    /**
     * @return CookieJar
     */
    protected function createCookieJar() {
        return new CookieJar($this);
    }

    /**
     * @return IUrl
     */
    protected function createUrl() {
        return new Url();
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
    protected function setDefaultContentType() {}

    /**
     * @return IHttpData
     */
    protected function createData() {
        $matcher = $this->getContentTypeDataMatcher();

        return $matcher->createDataForContentType($this, $this->getContentType());
    }

    /**
     * @return HttpBasicAuth
     */
    protected function createBasicAuth() {
        return new HttpBasicAuth($this);
    }

    /**
     * @return IContentTypeDataMatcher
     */
    protected function createContentTypeDataMatcher() {
        return new ContentTypeDataMatcher();
    }

    /**
     * @return ServerGlobal
     */
    protected function createServerGlobal() {
        return new ServerGlobal();
    }
}
