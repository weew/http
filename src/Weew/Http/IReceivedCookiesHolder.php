<?php

namespace Weew\Http;

interface IReceivedCookiesHolder {
    /**
     * @return IReceivedCookies
     */
    function getReceivedCookies();

    /**
     * @param IReceivedCookies $cookieJar
     */
    function setReceivedCookies(IReceivedCookies $cookieJar);
}
