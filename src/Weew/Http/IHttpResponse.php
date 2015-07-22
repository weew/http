<?php

namespace Weew\Http;

interface IHttpResponse extends
    IHeadersHolder,
    IContentHolder,
    IHttpProtocolHolder,
    IStatusHolder,
    ISendable,
    IExtendable {
}
