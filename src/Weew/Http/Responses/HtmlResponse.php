<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IHtmlContentHolder;
use Weew\Http\IHttpHeaders;

class HtmlResponse extends HttpResponse implements IHtmlContentHolder {
    /**
     * @param int $statusCode
     * @param null $content
     * @param IHttpHeaders|null $headers
     */
    public function __construct(
        $statusCode = HttpStatusCode::OK,
        $content = null,
        IHttpHeaders $headers = null
    ) {
        parent::__construct($statusCode, null, $headers);
        $this->setHtmlContent($content);
    }

    /**
     * @param $content
     */
    public function setHtmlContent($content) {
        $this->setDefaultContentType();
        $this->setContent($content);
    }

    /**
     * @return mixed
     */
    public function getHtmlContent() {
        return $this->getContent();
    }

    /**
     * @return string
     */
    protected function setDefaultContentType() {
        $this->setContentType('text/html');
    }
}
