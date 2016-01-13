<?php

namespace Weew\Http;

use Exception;
use Weew\Contracts\IStringable;

class HttpResponse implements IHttpResponse {
    /**
     * @var IHttpHeaders
     */
    protected $headers;

    /**
     * @var IHttpData
     */
    protected $data;

    /**
     * @var IContentTypeDataMatcher
     */
    protected $contentTypeDataMatcher;

    /**
     * @var ICookies
     */
    protected $cookies;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var null
     */
    protected $content;

    /**
     * @var string
     */
    protected $protocol = HttpProtocol::HTTP;

    /**
     * @var string
     */
    protected $version = HttpProtocol::CURRENT_VERSION;

    /**
     * @param int $statusCode
     * @param null $content
     * @param IHttpHeaders $headers
     */
    public function __construct(
        $statusCode = HttpStatusCode::OK,
        $content = null,
        IHttpHeaders $headers = null
    ) {
        if ($statusCode === null) {
            $statusCode = HttpStatusCode::OK;
        }

        if ( ! $headers instanceof IHttpHeaders) {
            $headers = $this->createHeaders();
        }

        $this->setStatusCode($statusCode);
        $this->setHeaders($headers);
        $this->setCookies($this->createCookies());
        $this->setContent($content);
        $this->setContentTypeDataMatcher($this->createContentTypeDataMatcher());

        $this->setDefaults();
    }

    /**
     * Use this method to transform a basic http response to its subclasses.
     *
     * @param IHttpResponse $httpResponse
     *
     * @return static
     */
    public static function create(IHttpResponse $httpResponse) {
        $customResponse = new static();
        $customResponse->extend($httpResponse);

        return $customResponse;
    }

    /**
     * Response headers are read only.
     *
     * @return IHttpHeaders
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * @param IHttpHeaders $headers
     *
     * @throws Exception
     */
    public function setHeaders(IHttpHeaders $headers) {
        $this->headers = $headers;
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
     * @return int
     */
    public function getStatusCode() {
        return $this->statusCode;
    }

    /**
     * @see HttpStatusCodes
     *
     * @param $statusCode
     */
    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getStatusText() {
        return HttpStatusCode::getStatusText($this->getStatusCode());
    }

    /**
     * Send response.
     */
    public function send() {
        $this->getResponseBuilder()->build($this);
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
        return ! empty($this->content);
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
     * @return ICookies
     */
    public function getCookies() {
        return $this->cookies;
    }

    /**
     * @param ICookies $cookies
     */
    public function setCookies(ICookies $cookies) {
        $this->cookies = $cookies;
    }

    /**
     * @param $content
     */
    public function setContent($content) {
        if ($content instanceof IStringable) {
            $content = $content->toString();
        } else if ( ! is_string($content)) {
            $content = (string) $content;
        }

        $this->content = $content;
    }

    /**
     * @return bool
     */
    public function isSecure() {
        return $this->getProtocol() == HttpProtocol::HTTPS;
    }

    /**
     * @param string $contentType
     */
    public function setContentType($contentType) {
        $this->getHeaders()->set('content-type', $contentType);
    }

    /**
     * @return string
     */
    public function getContentType() {
        return $this->getHeaders()->find('content-type');
    }

    /**
     * Check if response status code is 2xx.
     *
     * @return bool
     */
    public function isOk() {
        return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
    }

    /**
     * Check if response status code is 3xx.
     *
     * @return bool
     */
    public function isRedirect() {
        return $this->getStatusCode() >= 300 && $this->getStatusCode() < 400;
    }

    /**
     * Check if response status code is 4xx.
     *
     * @return bool
     */
    public function isClientError() {
        return $this->getStatusCode() >= 400 && $this->getStatusCode() < 500;
    }

    /**
     * Check if response status code is 5xx.
     *
     * @return bool
     */
    public function isServerError() {
        return $this->getStatusCode() >= 500 && $this->getStatusCode() < 600;
    }

    /**
     * Check if response status code is 4xx or 5xx.
     *
     * @return bool
     */
    public function isError() {
        return $this->isClientError() || $this->isServerError();
    }

    /**
     * Extend current response with another.
     *
     * @param IHttpResponse $response
     */
    public function extend(IHttpResponse $response) {
        $this->setHeaders(clone($response->getHeaders()));
        $this->setProtocol($response->getProtocol());
        $this->setProtocolVersion($response->getProtocolVersion());
        $this->setStatusCode($response->getStatusCode());
        $this->setContent($response->getContent());
        $this->setCookies(clone($response->getCookies()));

        $this->setDefaultContentType();
    }

    /**
     * @return array
     */
    public function toArray() {
        return [
            'protocol' => $this->getProtocol(),
            'version' => $this->getProtocolVersion(),
            'statusCode' => $this->getStatusCode(),
            'statusCodeText' => $this->getStatusText(),
            'headers' => $this->getHeaders()->toArray(),
            'content' => $this->getContent(),
        ];
    }

    /**
     * Use this as hook to extend your custom response.
     */
    protected function setDefaults() {
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
     * @return Cookies
     */
    protected function createCookies() {
        return new Cookies($this);
    }

    /**
     * @return IHttpResponseBuilder
     */
    protected function getResponseBuilder() {
        return new HttpResponseBuilder();
    }

    /**
     * Set the default content type of this response.
     */
    protected function setDefaultContentType() {}

    /**
     * @return HttpUrlEncodedData
     */
    protected function createData() {
        $matcher = new ContentTypeDataMatcher();

        return $matcher->createDataForContentType($this, $this->getContentType());
    }

    /**
     * @return IContentTypeDataMatcher
     */
    protected function createContentTypeDataMatcher() {
        return new ContentTypeDataMatcher();
    }
}
