<?php

namespace Weew\Http;

class HttpRequestMethod {
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const UPDATE = 'UPDATE';
    const PATCH = 'PATCH';
    const DELETE = 'DELETE';
    const OPTIONS = 'OPTIONS';
    const HEAD = 'HEAD';

    /**
     * @return array
     */
    public static function getMethods() {
        return [
            self::GET, self::POST, self::PUT,
            self::UPDATE, self::PATCH, self::DELETE,
            self::OPTIONS, self::HEAD,
        ];
    }
}
