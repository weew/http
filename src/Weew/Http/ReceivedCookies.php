<?php

namespace Weew\Http;

class ReceivedCookies implements IReceivedCookies {
    /**
     * @var IHttpHeaders
     */
    protected $headers;

    /**
     * @param IHttpHeaders $headers
     */
    public function __construct(IHttpHeaders $headers) {
        $this->headers = $headers;
    }

    /**
     * @param $name
     *
     * @return Cookie
     */
    public function findByName($name) {
        $cookies = $this->toArray();
        $value = array_get($cookies, $name);

        if ($value !== null) {
            return new Cookie($name, $value);
        }
    }

    /**
     * @return array
     */
    public function toArray() {
        $cookies = [];

        foreach ($this->headers->get('cookie') as $header) {
            $pairs = explode(';', $header);
            foreach ($pairs as $pair) {
                $parts = explode('=', $pair);
                $key = trim(array_get($parts, 0, ''));
                $value = trim(array_get($parts, 1, ''));

                if (strlen($key) > 0) {
                    $cookies[$key] = $value;
                }
            }
        }

        return $cookies;
    }
}
