<?php

namespace Weew\Http;

use Exception;
use Weew\Foundation\Interfaces\IStringable;

class HttpResponse implements IHttpResponse {
    /**
     * @var IHttpHeaders
     */
    protected $headers;

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
    protected $protocol = 'HTTP';

    /**
     * @var string
     */
    protected $version = '1.1';

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
        if ( ! $headers instanceof IHttpHeaders) {
            $headers = $this->createHeaders();
        }

        if ($statusCode === null) {
            $statusCode = HttpStatusCode::OK;
        }

        $this->setStatusCode($statusCode);
        $this->setHeaders($headers);
        $this->setContent($content);

        if ($this->getContentType() === null) {
            $this->setDefaultContentType();
        }

        // todo: test
        $this->setDefaults();
    }

    /**
     * Use this method to transform a basic http response to its subclasses.
     *
     * @param IHttpResponse $httpResponse
     * @param bool $forceContentType
     *
     * @return static
     */
    public static function create(IHttpResponse $httpResponse, $forceContentType = true) {
        $customResponse = new static();
        $customResponse->extend($httpResponse);

        if ($forceContentType) {
            $customResponse->setDefaultContentType();
        }

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
     * Use this as hook to extend your custom response.
     */
    protected function setDefaults() {}

    /**
     * @return HttpHeaders
     */
    protected function createHeaders() {
        return new HttpHeaders();
    }

    /**
     * @return IHttpResponseBuilder
     */
    protected function getResponseBuilder() {
        return new HttpResponseBuilder();
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
     * Set the default content type of this response.
     */
    protected function setDefaultContentType() {
        $this->setContentType('text/plain');
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
     */
    public function setProtocolVersion($version) {
        $this->version = $version;
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
    public function getContentType() {
        return $this->getHeaders()->get('Content-Type');
    }



    /**
     * @param $key
     * @param null $default
     *
     * @return string
     */
    public function getHeader($key, $default = null) {
        return $this->getHeaders()->get($key, $default);
    }

    /**
     * @param $key
     * @param $value
     */
    public function setHeader($key, $value) {
        $this->getHeaders()->set($key, $value);
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
        return $this->getStatusCode() >= 300 and $this->getStatusCode() < 400;
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
        return $this->isClientError() or $this->isServerError();
    }

    /**
     * Extend current response with another.
     *
     * @param IHttpResponse $response
     *
     * @return IHttpResponse
     */
    public function extend(IHttpResponse $response) {
        $this->setHeaders($response->getHeaders());
        $this->setProtocol($response->getProtocol());
        $this->setProtocolVersion($response->getProtocolVersion());
        $this->setContent($response->getContent());
        $this->setStatusCode($response->getStatusCode());
    }
}
