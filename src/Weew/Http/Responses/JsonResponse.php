<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Foundation\Interfaces\IArrayable;
use Weew\Foundation\Interfaces\IJsonable;
use Weew\Http\IJsonContentHolder;

class JsonResponse extends HttpResponse implements IJsonContentHolder {
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

        $this->setDefaultContentType();
        $this->setContent($content);
    }
}
