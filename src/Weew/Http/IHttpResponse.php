<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IHttpResponse extends
    IHttpHeadersHolder,
    IContentHolder,
    IHttpProtocolHolder,
    IStatusHolder,
    ICookiesHolder,
    ISendable,
    IArrayable {
}
