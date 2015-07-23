<?php

namespace Weew\Http;

interface IHttpData {
    /**
     * @return array
     */
    function getAll();

    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    function get($key, $default = null);

    /**
     * @param string $key
     * @param $value
     */
    function set($key, $value);

    /**
     * @param string $key
     *
     * @return bool
     */
    function has($key);

    /**
     * @param string $key
     */
    function remove($key);

    /**
     * @param $dataType
     *
     * @see HttpDataType
     */
    function setDataType($dataType);

    /**
     * @return string
     */
    function getDataType();

    /**
     * @return bool
     */
    function isMultipart();

    /**
     * @return bool
     */
    function isUrlEncoded();

    /**
     * @return mixed
     */
    function getDataEncoded();

    /**
     * @return int
     */
    function count();

    /**
     * @param array $data
     */
    function add(array $data);

    /**
     * @param array $data
     */
    function replace(array $data);
}
