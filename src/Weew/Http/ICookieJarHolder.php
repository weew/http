<?php

namespace Weew\Http;

interface ICookieJarHolder {
    /**
     * @return ICookieJar
     */
    function getCookieJar();

    /**
     * @param ICookieJar $cookieJar
     */
    function setCookieJar(ICookieJar $cookieJar);
}
