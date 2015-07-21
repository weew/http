<?php

namespace Weew\Http;

interface IStatusHolder {
    /**
     * @return int
     */
    function getStatusCode();

    /**
     * @see HttpStatusCodes
     *
     * @param $statusCode
     */
    function setStatusCode($statusCode);

    /**
     * @return string
     */
    function getStatusText();

    /**
     * @return bool
     */
    function isOk();
}
