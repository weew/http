<?php

namespace Weew\Http;

interface ICookiesHolder {
    /**
     * @return ICookies
     */
    function getCookies();

    /**
     * @param ICookies $cookies
     */
    function setCookies(ICookies $cookies);
}
