<?php

namespace Weew\Http;

interface IHttpProtocolHolder {
    /**
     * @return string
     */
    function getProtocol();

    /**
     * @param $protocol
     *
     * @see HttpProtocol
     */
    function setProtocol($protocol);

    /**
     * @return string
     */
    function getProtocolVersion();

    /**
     * @param $version
     *
     * @see HttpProtocol
     */
    function setProtocolVersion($version);

    /**
     * @return bool
     */
    function isSecure();
}
