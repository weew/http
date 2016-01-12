<?php

namespace Weew\Http\Requests;

use Weew\Http\HttpRequest;
use Weew\Http\IJsonContentHolder;
use Weew\JsonEncoder\JsonEncoder;

class JsonRequest extends HttpRequest implements IJsonContentHolder {
    /**
     * @param bool $assoc
     *
     * @return array
     */
    public function getJsonContent($assoc = true) {
        $content = $this->getContent();

        if ($content !== null) {
            $content = (new JsonEncoder())->decode($content, $assoc);
        }

        return $content;
    }

    /**
     * @param $content
     * @param int $options
     */
    public function setJsonContent($content, $options = 0) {
        if ($content !== null) {
            $content = (new JsonEncoder())->encode($content, $options);
        }

        $this->setDefaultContentType();
        $this->setContent($content);
    }

    /**
     * Set accept.
     */
    protected function setDefaultAccept() {
        $this->setAccept('application/json');
    }

    /**
     * Set content type.
     */
    protected function setDefaultContentType() {
        $this->setContentType('application/json');
    }
}
