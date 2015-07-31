<?php

namespace Weew\Http;

class HttpData implements IHttpData {
    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var string
     */
    protected  $dataType = HttpDataType::URL_ENCODED;

    /**
     * @param array $data
     */
    public function __construct(array $data = []) {
        $this->data = $data;
    }

    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null) {
        return array_get($this->data, $key, $default);
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set($key, $value) {
        array_set($this->data, $key, $value);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key) {
        return array_has($this->data, $key);
    }

    /**
     * @param string $key
     */
    public function remove($key) {
        array_remove($this->data, $key);
    }

    /**
     * @param array $data
     */
    public function add(array $data) {
        $this->data = array_extend($this->data, $data);
    }

    /**
     * @param array $data
     */
    public function replace(array $data) {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getDataType() {
        return $this->dataType;
    }

    /**
     * @param $dataType
     *
     * @see HttpDataType
     */
    public function setDataType($dataType) {
        $this->dataType = $dataType;
    }

    /**
     * @return bool
     */
    public function isMultipart() {
        return $this->dataType === HttpDataType::MULTI_PART;
    }

    /**
     * @return bool
     */
    public function isUrlEncoded() {
        return $this->dataType === HttpDataType::URL_ENCODED;
    }

    /**
     * @return array|string
     */
    public function getDataEncoded() {
        if ($this->isMultipart()) {
            return $this->data;
        } else {
            return http_build_query($this->data);
        }
    }

    /**
     * @return int
     */
    public function count() {
        return count($this->data);
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->data;
    }
}
