<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Foundation\Interfaces\IArrayable;
use Weew\Foundation\Interfaces\IJsonable;
use Weew\Http\HttpStatusCode;
use Weew\Http\IJsonContentHolder;

class JsonResponse extends HttpResponse implements IJsonContentHolder {
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
        $this->setJsonContent($content);
    }

    /**
     * Set content type.
     */
    protected function setDefaultContentType() {
        $this->setContentType('application/json');
    }

    /**
     * @param bool|true $assoc
     *
     * @return string|null
     */
    public function getJsonContent($assoc = true) {
        if ($this->hasContent()) {
            return json_decode($this->getContent(), $assoc);
        }

        return null;
    }

    /**
     * @param $content
     * @param int $options
     */
    public function setJsonContent($content, $options = 0) {
        if ($content instanceof IJsonable) {
            $content = $content->toJson($options);
        } else if ($content !== null) {
            if ($content instanceof IArrayable) {
                $content = $content->toArray();
            }

            $content = json_encode($content, $options);
        }

        $this->setDefaultContentType();
        $this->setContent($content);
    }
}
