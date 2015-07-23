<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IHttpHeaders extends IArrayable {
    /**
     * @return array
     */
    function getAll();

    /**
     * @param $key
     * @param null $default
     *
     * @return string or null
     */
    function get($key, $default = null);

    /**
     * @param $key
     *
     * @return bool
     */
    function has($key);

    /**
     * @param $key
     * @param $value
     */
    function set($key, $value);

    /**
     * @param $key
     */
    function remove($key);
}
