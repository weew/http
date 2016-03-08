<?php

namespace Weew\Http;

class SuperGlobal implements ISuperGlobal {
    /**
     * @var array
     */
    protected $global;

    /**
     * SuperGlobal constructor.
     *
     * @param array $global
     */
    public function __construct(array &$global = []) {
        $this->global = &$global;
    }

    /**
     * @param $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null) {
        return array_get($this->global, $key, $default);
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value) {
        array_set($this->global, $key, $value);
    }

    /**
     * @param $key
     *
     * @return bool
     */
    public function has($key) {
        return array_has($this->global, $key);
    }

    /**
     * @param $key
     */
    public function remove($key) {
        array_remove($this->global, $key);
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->global;
    }
}
