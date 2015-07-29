<?php

namespace Weew\Http;

use Weew\Foundation\Interfaces\IArrayable;

interface IHttpResponse extends
    IHeadersHolder,
    IContentHolder,
    IHttpProtocolHolder,
    IStatusHolder,
    ISendable,
    IExtendable,
    IArrayable {
}
