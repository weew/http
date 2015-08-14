<?php

namespace Weew\Http;

interface ICookieBuilder {
    /**
     * @param ICookie $cookie
     *
     * @return string
     */
    function build(ICookie $cookie);
}
