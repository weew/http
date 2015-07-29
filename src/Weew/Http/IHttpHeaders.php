<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IHttpHeaders extends IArrayable {
    /**
     * @param bool $distinct
     *
     * @return array
     */
    function getAll($distinct = true);

    /**
     * @param $key
     * @param null $default
     * @param bool $distinct
     *
     * @return string or null
     */
    function get($key, $default = null, $distinct = true);

    /**
     * @param $key
     *
     * @return bool
     */
    function has($key);

    /**
     * @param $key
     * @param $value
     * @param bool $replace
     *
     * @return
     */
    function set($key, $value, $replace = true);

    /**
     * @param $key
     */
    function remove($key);
}
