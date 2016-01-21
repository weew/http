<?php

namespace Weew\Http\Data;

use Weew\Http\HttpDataType;
use Weew\Http\IContentHolder;
use Weew\Http\IHttpData;
use Weew\JsonEncoder\IJsonEncoder;
use Weew\JsonEncoder\JsonEncoder;

class JsonData implements IHttpData {
    /**
     * @var string
     */
    protected $dataType = HttpDataType::JSON;

    /**
     * @var IContentHolder
     */
    protected $holder;

    /**
     * JsonData constructor.
     *
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
        $data = $this->getJsonEncoder()->decode($this->holder->getContent());

        return $data !== null ? $data : [];
    }

    /**
     * @param array $data
     */
    public function setData(array $data) {
        $this->holder->setContentType($this->getDataType());
        $this->holder->setContent($this->getJsonEncoder()->encode($data));
    }

    /**
     * @return bool
     */
    public function hasData() {
        return ! empty($this->getData());
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
     * @return string
     */
    public function getDataType() {
        return $this->dataType;
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
        return $this->getJsonEncoder()->encode($this->getData());
    }

    /**
     * @return IJsonEncoder
     */
    protected function getJsonEncoder() {
        return new JsonEncoder();
    }
}
