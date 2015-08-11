<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;
use Weew\Foundation\Interfaces\IStringable;

interface IHttpData extends IStringable, IArrayable {
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
     * @param array $data
     */
    function add(array $data);

    /**
     * @return int
     */
    function count();

    /**
     * @return array
     */
    function getData();

    /**
     * @param array $data
     */
    function setData(array $data);

    /**
     * @return bool
     */
    function hasData();

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
     * @return string
     */
    function getDataEncoded();

    /**
     * @param string $data
     */
    function setDataEncoded($data);
}
