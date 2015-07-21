<?php

namespace Weew\Http\Requests;

use Weew\Foundation\Interfaces\IArrayable;
use Weew\Foundation\Interfaces\IJsonable;
use Weew\Http\HttpRequest;
use Weew\Http\IJsonContentHolder;

class JsonRequest extends HttpRequest implements IJsonContentHolder {
    /**
     * @return string
     */
    protected function getDefaultAccept() {
        return 'application/json';
    }

    /**
     * @return string
     */
    protected function getDefaultContentType() {
        return 'application/json';
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
        } else if ($content instanceof IArrayable) {
            $content = json_encode($content->toArray(), $options);
        } else {
            $content = json_encode($content, $options);
        }
        $this->setContent($content);
    }
}
