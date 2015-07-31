<?php

namespace Weew\Http;

interface IHttpCookies extends IHeadersAware {
    /**
     * @return array
     */
    function getAll();

    /**
     * @param ICookie $cookie
     */
    function add(ICookie $cookie);

    /**
     * @param $name
     *
     * @return ICookie
     */
    function getByName($name);

    /**
     * @param $name
     */
    function removeByName($name);
}
