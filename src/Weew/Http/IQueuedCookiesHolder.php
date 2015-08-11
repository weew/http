<?php

namespace Weew\Http;

interface IQueuedCookiesHolder {
    /**
     * @return IQueuedCookies
     */
    function getQueuedCookies();

    /**
     * @param IQueuedCookies $cookies
     */
    function setQueuedCookies(IQueuedCookies $cookies);
}
