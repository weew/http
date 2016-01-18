<?php

namespace Weew\Http\Responses;

use Weew\Contracts\IArrayable;
use Weew\Contracts\IJsonable;
use Weew\Contracts\IStringable;
use Weew\Http\Data\JsonData;
use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IHttpHeaders;

class JsonResponse extends HttpResponse {
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

        if (is_array($content) && ! empty($content)) {
            $this->getData()->setData($content);
        } else if ($content instanceof IArrayable) {
            $this->getData()->setData($content->toArray());
        } else if ($content instanceof IJsonable) {
            $this->setContent($content->toJson());
        } else {
            $this->setContent($content);
        }
    }

    /**
     * @return JsonData
     */
    protected function createData() {
        return new JsonData($this);
    }

    /**
     * Set content type.
     */
    protected function setDefaultContentType() {
        $this->setContentType('application/json');
    }
}
