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

    /**
     * @return bool
     */
    function isRedirect();

    /**
     * @return bool
     */
    function isError();

    /**
     * @return bool
     */
    function isServerError();

    /**
     * @return bool
     */
    function isClientError();
}
