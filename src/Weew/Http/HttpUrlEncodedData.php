<?php

namespace Weew\Http;

class HttpUrlEncodedData implements IHttpData {
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
     * @param array $data
     */
    public function setData(array $data) {
        $this->holder->setContent(http_build_query($data));
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
}
