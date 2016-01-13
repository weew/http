<?php

namespace Weew\Http\Responses;

use Weew\Http\Data\HttpJsonData;
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

        if ( ! empty($content)) {
            $this->getData()->setData($content);
        }
    }

    /**
     * @return HttpJsonData
     */
    protected function createData() {
        return new HttpJsonData($this);
    }

    /**
     * Set content type.
     */
    protected function setDefaultContentType() {
        $this->setContentType('application/json');
    }
}
