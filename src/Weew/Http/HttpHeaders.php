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
     * Add header.
     *
     * @param $key
     * @param $value
     */
    public function add($key, $value) {
        $key = $this->formatKey($key);
        $headers = $this->get($key);

        if ($headers === null) {
            $headers = [];
        }

        $headers[] = $value;

        array_set($this->headers, $key, $headers);
    }

    /**
     * Find the last added header.
     *
     * @param $key
     * @param null $default
     *
     * @return string
     */
    public function find($key, $default = null) {
        $key = $this->formatKey($key);
        $headers = array_get($this->headers, $key, $default);

        if (is_array($headers)) {
            $headers = array_pop($headers);
        }

        return $headers;
    }

    /**
     * Replace all previous headers with this one.
     *
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        $key = $this->formatKey($key);
        array_set($this->headers, $key, [$value]);
    }

    /**
     * Get all headers by key.
     *
     * @param $key
     *
     * @return string
     */
    public function get($key) {
        $key = $this->formatKey($key);
        return array_get($this->headers, $key);
    }

    /**
     * Check if there are any headers.
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key) {
        $key = $this->formatKey($key);
        return array_has($this->headers, $key);
    }

    /**
     * Remove all registered headers.
     *
     * @param $key
     */
    public function remove($key) {
        $key = $this->formatKey($key);
        array_remove($this->headers, $key);
    }

    /**
     * @param $key
     * @param $header
     *
     * @return string
     */
    public function formatHeader($key, $header) {
        return s('%s: %s', $key, $header);
    }

    /**
     * @param $key
     *
     * @return string
     */
    public function formatKey($key) {
        return mb_strtolower($key);
    }

    /**
     * Get an array of header keys and all assigned header values.
     *
     * @return array
     */
    public function toArray() {
        return $this->headers;
    }

    /**
     * Get an array of hey keys and the most recent header values.
     *
     * @return array
     */
    public function toDistinctArray() {
        $array = [];

        foreach ($this->headers as $key => $headers) {
            $array[$key] = array_pop($headers);
        }

        return $array;
    }

    /**
     * Get a list of formatted header strings.
     *
     * @return array
     */
    public function toFlatArray() {
        $array = [];

        foreach ($this->headers as $key => $headers) {
            foreach ($headers as $header) {
                $array[] = $this->formatHeader($key, $header);
            }
        }

        return $array;
    }
}
