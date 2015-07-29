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
            $this->set($key, $value, true);
        }
    }

    /**
     * @param bool $distinct
     *
     * @return array
     */
    public function getAll($distinct = true) {
        if ($distinct) {
            $headers = [];

            foreach ($this->headers as $key => $value) {
                $headers[$key] = $this->get($key);
            }

            return $headers;
        }

        return $this->headers;
    }

    /**
     * @param $key
     * @param null $default
     * @param bool $distinct
     *
     * @return string or null
     */
    public function get($key, $default = null, $distinct = true) {
        $value = array_get($this->headers, $key, $default);

        if ($distinct and is_array($value)) {
            return array_pop($value);
        }

        return $value;
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
     * @param bool $replace
     */
    public function set($key, $value, $replace = true) {
        if ( ! $replace and $this->has($key)) {
            $headers = $this->get($key);

            if ( ! is_array($headers)) {
                $headers = [$headers];
            }

            $headers[] = $value;

            array_set($this->headers, $key, $headers);
        } else {
            array_set($this->headers, $key, $value);
        }
    }

    /**
     * @param $key
     */
    public function remove($key) {
        array_remove($this->headers, $key);
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->getAll(false);
    }
}
