<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;
use Weew\Foundation\Interfaces\IStringable;

interface ICookie extends IStringable, ISendable, IArrayable {
    /**
     * @return string
     */
    function getName();

    /**
     * @param string $name
     */
    function setName($name);

    /**
     * @return bool
     */
    function hasName();

    /**
     * @return string
     */
    function getValue();

    /**
     * @param string $value
     */
    function setValue($value);

    /**
     * @return bool
     */
    function hasValue();

    /**
     * @return int
     */
    function getMaxAge();

    /**
     * @param int $maxAge
     */
    function setMaxAge($maxAge);

    /**
     * @return bool
     */
    function hasMaxAge();

    /**
     * @return int
     */
    function getExpires();

    /**
     * @return string
     */
    function getExpiresDate();

    /**
     * @return string
     */
    function getPath();

    /**
     * @param string $path
     */
    function setPath($path);

    /**
     * @return bool
     */
    function hasPath();

    /**
     * @return string
     */
    function getDomain();

    /**
     * @param string $path
     */
    function setDomain($path);

    /**
     * @return bool
     */
    function hasDomain();

    /**
     * @return bool
     */
    function getSecure();

    /**
     * @param bool $secure
     */
    function setSecure($secure);

    /**
     * @return bool
     */
    function isSecure();

    /**
     * @return bool
     */
    function getHttpOnly();

    /**
     * @param bool $httpOnly
     */
    function setHttpOnly($httpOnly);

    /**
     * @return bool
     */
    function isHttpOnly();
}
