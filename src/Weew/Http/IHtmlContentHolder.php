<?php

namespace Weew\Http;

interface IHtmlContentHolder {
    /**
     * @param $content
     */
    function setHtmlContent($content);

    /**
     * @return mixed
     */
    function getHtmlContent();
}
