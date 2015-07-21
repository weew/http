<?php

namespace Weew\Http;

class HttpHeaders implements IHttpHeaders {
    /**
     * @var array
     */
    protected $headers = [];

    /**
     * @param array $headers
     */
    public function __construct(array $headers = []) {
        foreach ($headers as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @return array
     */
    public function getAll() {
        return $this->headers;
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return string or null
     */
    public function get($key, $default = null) {
        return array_get($this->headers, $key, $default);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key) {
        return array_has($this->headers, $key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        array_set($this->headers, $key, $value);
    }

    /**
     * @param $key
     */
    public function remove($key) {
        array_remove($this->headers, $key);
    }
}
