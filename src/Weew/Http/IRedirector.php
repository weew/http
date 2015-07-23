<?php

namespace Weew\Http;

use Weew\Url\IUrl;

interface IRedirector {
    /**
     * @return IUrl
     */
    function getDestination();

    /**
     * @param IUrl $url
     */
    function setDestination(IUrl $url);
}
