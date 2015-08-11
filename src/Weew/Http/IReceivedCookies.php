<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IReceivedCookies extends IArrayable {
    /**
     * @param $name
     *
     * @return ICookie
     */
    function findByName($name);
}
