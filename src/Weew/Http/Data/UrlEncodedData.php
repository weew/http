<?php

namespace Weew\Http\Data;

use Weew\Http\DataSerializer;
use Weew\Http\HttpDataType;
use Weew\Http\IContentHolder;
use Weew\Http\IDataSerializer;
use Weew\Http\IHttpData;

class UrlEncodedData implements IHttpData {
    /**
     * @var string
     */
    protected $dataType = HttpDataType::URL_ENCODED;

    /**
     * @var IContentHolder
     */
    protected $holder;

    /**
     * @param IContentHolder $holder
     * @param array $data
     */
    public function __construct(IContentHolder $holder, array $data = []) {
        $this->holder = $holder;

        if ( ! empty($data)) {
            $this->setData($data);
        }
    }

    /**
     * @param string $key
     * @param null $default
     *
     * @return mixed
     */
    public function get($key, $default = null) {
        return array_get($this->getData(), $key, $default);
    }

    /**
     * @param array $keys
     *
     * @return array
     */
    public function pick(array $keys) {
        $data = [];

        foreach ($keys as $key) {
            array_set($data, $key, $this->get($key));
        }

        return $data;
    }

    /**
     * @param string $key
     * @param $value
     */
    public function set($key, $value) {
        $data = $this->getData();
        array_set($data, $key, $value);
        $this->setData($data);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key) {
        return array_has($this->getData(), $key);
    }

    /**
     * @param string $key
     */
    public function remove($key) {
        $data = $this->getData();
        array_remove($data, $key);
        $this->setData($data);
    }

    /**
     * @param array $data
     */
    public function extend(array $data) {
        $current = $this->getData();
        $extended = array_extend($current, $data);
        $this->setData($extended);
    }

    /**
     * @return array
     */
    public function getData() {
        $data = [];
        parse_str($this->holder->getContent(), $data);

        return $data;
    }

    /**
     * @param $data
     */
    public function setData($data) {
        $data = $this->getSerializer()->serialize($data);

        if (is_array($data)) {
            $data = http_build_query($data);
        }

        $this->holder->setContent($data);
        $this->holder->setContentType($this->getDataType());
    }

    /**
     * @return bool
     */
    public function hasData() {
        return ! empty($this->getData());
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
        return stripos($this->getDataType(), HttpDataType::MULTI_PART) !== false;
    }

    /**
     * @return bool
     */
    public function isUrlEncoded() {
        return stripos($this->getDataType(), HttpDataType::URL_ENCODED) !== false;
    }

    /**
     * @return array
     */
    public function toArray() {
        return $this->getData();
    }

    /**
     * @return string
     */
    public function toString() {
        return $this->holder->getContent();
    }

    /**
     * @return IDataSerializer
     */
    protected function getSerializer() {
        return new DataSerializer();
    }
}
