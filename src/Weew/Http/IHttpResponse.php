<?php

namespace Weew\Http;

use Weew\Contracts\IArrayable;

interface IHttpResponse extends
    IHttpHeadersHolder,
    IContentHolder,
    IHttpDataHolder,
    IHttpProtocolHolder,
    IStatusHolder,
    ICookiesHolder,
    ISendable,
    IArrayable {
}
