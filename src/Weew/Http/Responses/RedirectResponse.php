<?php

namespace Weew\Http\Responses;

use Weew\Http\HttpResponse;
use Weew\Http\HttpStatusCode;
use Weew\Http\IRedirector;
use Weew\Url\IUrl;

class RedirectResponse extends HttpResponse implements IRedirector {
    /**
     * @var IUrl
     */
    protected $destination;

    /**
     * @param IUrl $destination
     * @param int|null $statusCode
     * @param null $content
     * @param IHttpHeaders $headers
     */
    public function __construct(
        IUrl $destination,
        $statusCode = HttpStatusCode::TEMPORARY_REDIRECT,
        $content = null,
        IHttpHeaders $headers = null
    ) {
        parent::__construct($statusCode, $content, $headers);

        $this->setDestination($destination);
    }

    /**
     * @return IUrl
     */
    public function getDestination() {
        return $this->destination;
    }

    /**
     * @param IUrl $destination
     */
    public function setDestination(IUrl $destination) {
        $this->destination = $destination;
        $this->setHeader('Location', $destination->toString());
    }
}
