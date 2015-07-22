<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Http\IHtmlContentHolder;

class HtmlResponse extends HttpResponse implements IHtmlContentHolder {
    /**
     * @return string
     */
    protected function setDefaultContentType() {
        $this->setContentType('text/html');
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
}
