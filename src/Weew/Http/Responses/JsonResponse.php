<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IJsonContentHolder;
use Weew\JsonEncoder\JsonEncoder;

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
     * @param bool|true $assoc
     *
     * @return string|null
     */
    public function getJsonContent($assoc = true) {
        $content = $this->getContent();

        if ($content !== null) {
            $content = (new JsonEncoder())->decode($this->getContent(), $assoc);
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
     * Set content type.
     */
    protected function setDefaultContentType() {
        $this->setContentType('application/json');
    }
}
