<?php

namespace Weew\Http\Requests;

use Weew\Foundation\Interfaces\IArrayable;
use Weew\Foundation\Interfaces\IJsonable;
use Weew\Http\HttpRequest;
use Weew\Http\IJsonContentHolder;

class JsonRequest extends HttpRequest implements IJsonContentHolder {
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

    /**
     * @param bool $assoc
     *
     * @return array
     */
    public function getJsonContent($assoc = true) {
        return json_decode($this->getContent(), $assoc);
    }

    /**
     * @param $content
     * @param int $options
     */
    public function setJsonContent($content, $options = 0) {
        if ($content instanceof IJsonable) {
            $content = $content->toJson($options);
        } else {
            if ($content instanceof IArrayable) {
                $content = $content->toArray();
            }

            $content = json_encode($content, $options);
        }

        $this->setContent($content);
    }
}
