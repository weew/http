<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IHttpHeaders;

class BasicAuthResponse extends HttpResponse {
    /**
     * @var string
     */
    protected $realm;

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

        $this->setRealm($realm);
    }

    /**
     * @return string
     */
    public function getRealm() {
        return $this->realm;
    }

    /**
     * @param $realm
     */
    public function setRealm($realm) {
        $this->realm = $realm;
        $this->getHeaders()->set('www-authenticate', s('basic realm="%s"', $realm));
    }
}
