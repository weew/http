<?php

namespace Weew\Http;

use Weew\Contracts\IArrayable;

interface ICookieJar extends IArrayable {
    /**
     * @param $name
     * @param null $default
     *
     * @return string
     */
    function get($name, $default = null);

    /**
     * @param $name
     * @param $value
     */
    function set($name, $value);
}
