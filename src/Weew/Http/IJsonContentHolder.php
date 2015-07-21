<?php

namespace Weew\Http;

interface IJsonContentHolder {
    /**
     * @param bool $assoc
     *
     * @return array
     */
    function getJsonContent($assoc = true);

    /**
     * @param $content
     * @param int $options
     */
    function setJsonContent($content, $options = 0);
}
