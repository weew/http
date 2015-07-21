<?php

namespace Weew\Http;

interface IBasicAuthHolder {
    /**
     * @return IHttpBasicAuth
     */
    function getBasicAuth();

    /**
     * @param IHttpBasicAuth $basicAuth
     */
    function setBasicAuth(IHttpBasicAuth $basicAuth);
}
