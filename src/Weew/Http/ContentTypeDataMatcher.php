<?php

namespace Weew\Http;

use Weew\Http\Data\JsonData;
use Weew\Http\Data\UrlEncodedData;
use Weew\Http\Exceptions\InvalidDataClassException;

class ContentTypeDataMatcher implements IContentTypeDataMatcher {
    /**
     * @var array
     */
    protected $mappings = [];

    /**
     * ContentTypeDataMatcher constructor.
     */
    public function __construct() {
        $this->registerDefaultMappings();
    }

    /**
     * @param IContentHolder $holder
     * @param string $contentType
     *
     * @return IHttpData
     */
    public function createDataForContentType(IContentHolder $holder, $contentType) {
        $parts = $this->parseContentType($contentType);

        foreach ($parts as $part) {
            $class = array_get($this->getMappings(), $part);

            if ($class !== null) {
                break;
            }
        }

        if ($class === null) {
            $class = $this->getDefaultDataClass();
        }

        return new $class($holder);
    }

    /**
     * @return array
     */
    public function getMappings() {
        return $this->mappings;
    }

    /**
     * @param array $mappings
     *
     * @throws InvalidDataClassException
     */
    public function setMappings(array $mappings) {
        $this->mappings = [];

        foreach ($mappings as $contentType => $dataClass) {
            $this->addMapping($contentType, $dataClass);
        }
    }

    /**
     * @param string $contentType
     * @param string $dataClass
     *
     * @throws InvalidDataClassException
     */
    public function addMapping($contentType, $dataClass) {
        if ( ! class_exists($dataClass)
            || ! array_contains(class_implements($dataClass), IHttpData::class)) {
            throw new InvalidDataClassException(
                s('Class "%s" must implement the "%s" interface.',
                    $dataClass, IHttpData::class)
            );
        }

        $this->mappings[$contentType] = $dataClass;
    }

    /**
     * @param string $contentType
     *
     * @return array
     */
    protected function parseContentType($contentType) {
        $parts = explode(';', $contentType);

        foreach ($parts as $key => $value) {
            $parts[$key] = trim($value);
        }

        return $parts;
    }

    /**
     * @throws InvalidDataClassException
     */
    protected function registerDefaultMappings() {
        $this->addMapping('application/json', JsonData::class);
    }

    /**
     * @return string
     */
    protected function getDefaultDataClass() {
        return UrlEncodedData::class;
    }
}
