<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IHttpHeaders extends IArrayable {
    /**
     * Add header.
     *
     * @param $key
     * @param $value
     */
    function add($key, $value);

    /**
     * Find the last added header.
     *
     * @param $key
     * @param null $default
     *
     * @return string
     */
    function find($key, $default = null);

    /**
     * Replace all previous headers with this one.
     *
     * @param $key
     * @param $value
     */
    function set($key, $value);

    /**
     * Get all headers by key.
     *
     * @param $key
     *
     * @return string
     */
    function get($key);

    /**
     * Check if there are any headers.
     *
     * @param $key
     *
     * @return bool
     */
    function has($key);

    /**
     * Remove all registered headers.
     *
     * @param $key
     */
    function remove($key);

    /**
     * @param string $key
     * @param string $header
     *
     * @return string
     */
    function formatHeader($key, $header);

    /**
     * @return array
     */
    function toDistinctArray();

    /**
     * @return array
     */
    function toFlatArray();
}
