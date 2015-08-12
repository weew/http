<?php

namespace Weew\Http;

class CookieJar implements ICookieJar {
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
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $cookies = $this->parseCookies();
        $cookies[$key] = $value;
        $this->buildCookies($cookies);
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return string
     */
    public function get($key, $default = null) {
        $cookies = $this->toArray();

        return array_get($cookies, $key, $default);
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->parseCookies();
    }

    /**
     * @param $key
     * @param $value
     *
     * @return string
     */
    protected function formatCookie($key, $value) {
        return s('%s=%s;', $key, $value);
    }

    /**
     * @return array
     */
    protected function parseCookies() {
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

    /**
     * @param array $cookies
     */
    protected function buildCookies(array $cookies) {
        $header = '';

        foreach ($cookies as $key => $value) {
            $header.= $this->formatCookie($key, $value) . ' ';
        }

        $this->headers->set('cookie', $header);
    }
}
