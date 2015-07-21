<?php

namespace Weew\Http;

interface IContentHolder {
    /**
     * @param $content
     */
    function setContent($content);

    /**
     * @return mixed
     */
    function getContent();

    /**
     * @return bool
     */
    function hasContent();

    /**
     * @return string
     */
    function getContentType();

    /**
     * @param string $contentType
     */
    function setContentType($contentType);
}
