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
        $this->writeContent($content);
    }

    /**
     * @param $content
     */
    protected function writeContent($content) {
        $content  = $this->serializeContent($content);

        if (is_array($content)) {
            $this->getData()->setData($content);
        } else {
            $this->setContent($content);
        }
    }

    /**
     * @param $content
     *
     * @return array|string
     */
    protected function serializeContent($content) {
        if (is_array($content)) {
            return $this->serializeArray($content);
        }

        return $this->serializeItem($content);
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function serializeArray(array $array) {
        $data = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->serializeArray($value);
            } else {
                $data[$key] = $this->serializeItem($value);
            }
        }

        return $data;
    }

    /**
     * @param $content
     *
     * @return array|string
     */
    protected function serializeItem($content) {
        if ($content instanceof IArrayable) {
            return $content->toArray();
        } else if ($content instanceof IJsonable) {
            return $content->toJson();
        } else if ($content instanceof IStringable) {
            return $content->toString();
        }

        return $content;
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
