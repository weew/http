<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Http\IHtmlContentHolder;
use Weew\Http\IHttpResponse;

class HtmlResponse extends HttpResponse implements IHtmlContentHolder {
    /**
     * @param IHttpResponse $response
     */
    public function extend(IHttpResponse $response) {
        parent::extend($response);
        $this->setDefaultContentType();
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
