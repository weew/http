<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface ICookies extends IArrayable {
    /**
     * @param ICookie $cookie
     */
    function add(ICookie $cookie);

    /**
     * @param $name
     *
     * @return ICookie
     */
    function findByName($name);

    /**
     * @param $name
     */
    function removeByName($name);
}
