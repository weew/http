<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IHttpHeaders;

class BasicAuthResponse extends HttpResponse {
    /**
     * @param string $realm
     * @param int|null $statusCode
     * @param IHttpHeaders|null $headers
     */
    public function __construct(
        $realm = 'Basic Auth',
        $statusCode = HttpStatusCode::UNAUTHORIZED,
        IHttpHeaders $headers = null
    ) {
        parent::__construct($statusCode, null, $headers);

        $this->setHeader('WWW-Authenticate', s('Basic realm="%s"', $realm));
    }
}
