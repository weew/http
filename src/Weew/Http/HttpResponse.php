<?php

namespace Weew\Http;

use Exception;
use Weew\Foundation\Interfaces\IArrayable;
use Weew\Foundation\Interfaces\IJsonable;

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
     * Use this as hook to extend your custom response.
     */
    protected function setDefaults() {}

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
     * @return HttpHeaders
     */
    protected function createHeaders() {
        return new HttpHeaders();
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
     * @return IHttpResponseBuilder
     */
    protected function getResponseBuilder() {
        return new HttpResponseBuilder();
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
    public function getProtocol() {
        return $this->protocol;
    }

    /**
     * @param $protocol
     *
     * @throws Exception
     */
    public function setProtocol($protocol) {
        throw new Exception('Protocol is read only.');
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
     * @throws Exception
     */
    public function setProtocolVersion($version) {
        throw new Exception('Protocol version is read only.');
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
     * Set the default content type of this response.
     */
    protected function setDefaultContentType() {
        $this->setContentType('text/plain');
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
     * @return bool
     */
    public function isOk() {
        return $this->getStatusCode() >= 200 && $this->getStatusCode() < 300;
    }

    /**
     * @param bool $assoc
     *
     * @return array
     */
    public function getJsonContent($assoc = true) {
        if ($this->hasContent()) {
            return json_decode($this->getContent(), $assoc);
        }
    }

    /**
     * @param $content
     * @param int $options
     */
    public function setJsonContent($content, $options = 0) {

        if ($content instanceof IArrayable) {
            $content = json_encode($content->toArray(), $options);
        } else if ($content instanceof IJsonable) {
            $content = $content->toJson($options);
        } else {
            $content = json_encode($content, $options);
        }

        $this->setContentType('application/json');
        $this->setContent($content);
    }
}
