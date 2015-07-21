<?php

namespace Weew\Http;

interface IHttpProtocolHolder {
    /**
     * @return string
     */
    function getProtocol();

    /**
     * @param $protocol
     */
    function setProtocol($protocol);

    /**
     * @return string
     */
    function getProtocolVersion();

    /**
     * @param $version
     */
    function setProtocolVersion($version);
}
