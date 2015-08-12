<?php

namespace Weew\Http;

interface ICookieParser {
    /**
     * @param $string
     *
     * @return ICookie
     */
    function parse($string);
}
