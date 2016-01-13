<?php

namespace Weew\Http;

interface IHttpDataHolder {
    /**
     * @return IHttpData
     */
    function getData();

    /**
     * @param IHttpData $data
     */
    function setData(IHttpData $data);

    /**
     * @return IContentTypeDataMatcher
     */
    function getContentTypeDataMatcher();

    /**
     * @param IContentTypeDataMatcher $contentTypeDataMatcher
     */
    function setContentTypeDataMatcher(
        IContentTypeDataMatcher $contentTypeDataMatcher
    );
}
