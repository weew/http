<?php

namespace Weew\Http;

interface IContentTypeDataMatcher {
    /**
     * @param IContentHolder $holder
     * @param string $contentType
     *
     * @return IHttpData
     */
    function createDataForContentType(IContentHolder $holder, $contentType);

    /**
     * @return array
     */
    function getMappings();

    /**
     * @param array $mappings
     */
    function setMappings(array $mappings);

    /**
     * @param string $contentType
     * @param string $dataClass
     */
    function addMapping($contentType, $dataClass);
}
