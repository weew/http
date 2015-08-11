<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IHttpResponse extends
    IHttpHeadersHolder,
    IContentHolder,
    IHttpProtocolHolder,
    IStatusHolder,
    IQueuedCookiesHolder,
    ISendable,
    IArrayable {
}
