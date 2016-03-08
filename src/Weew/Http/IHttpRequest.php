<?php

namespace Weew\Http;

use Weew\Contracts\IArrayable;
use Weew\Url\IUrl;

interface IHttpRequest extends
    IHttpHeadersHolder,
    IHttpProtocolHolder,
    IBasicAuthHolder,
    IContentHolder,
    IHttpDataHolder,
    ICookieJarHolder,
    IArrayable {
    /**
     * @return string
     *
     * @see HttpRequestMethods
     */
    function getMethod();

    /**
     * @param $method
     *
     * @see HttpRequestMethods
     */
    function setMethod($method);

    /**
     * @return IUrl
     */
    function getUrl();

    /**
     * @param IUrl $url
     */
    function setUrl(IUrl $url);

    /**
     * @return string
     */
    function getAccept();

    /**
     * @param string $accept
     */
    function setAccept($accept);

    /**
     * @return ISuperGlobal
     */
    function getServerGlobal();

    /**
     * @param ISuperGlobal $serverGlobal
     */
    function setServerGlobal(ISuperGlobal $serverGlobal);
}
