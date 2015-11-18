<?php

namespace Weew\Http;

use Weew\Contracts\IArrayable;

interface IHttpResponse extends
    IHttpHeadersHolder,
    IContentHolder,
    IHttpProtocolHolder,
    IStatusHolder,
    ICookiesHolder,
    ISendable,
    IArrayable {
}
