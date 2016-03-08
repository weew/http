<?php

namespace Weew\Http;

use Weew\Contracts\IArrayable;

interface ISuperGlobal extends IArrayable {
    /**
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    function get($key, $default = null);

    /**
     * @param $key
     * @param $value
     */
    function set($key, $value);

    /**
     * @param $key
     *
     * @return bool
     */
    function has($key);

    /**
     * @param $key
     */
    function remove($key);
}
