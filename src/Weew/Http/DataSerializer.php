<?php

namespace Weew\Http;

use Weew\Contracts\IArrayable;
use Weew\Contracts\IJsonable;
use Weew\Contracts\IStringable;

class DataSerializer implements IDataSerializer {
    /**
     * @param $data
     *
     * @return array|string
     */
    public function serialize($data) {
        if (is_array($data)) {
            return $this->serializeArray($data);
        } else if (is_object($data)) {
            return $this->serializeItem($data);
        }

        return $data;
    }

    /**
     * @param array $array
     *
     * @return array
     */
    protected function serializeArray(array $array) {
        $data = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->serializeArray($value);
            } else {
                $data[$key] = $this->serializeItem($value);
            }
        }

        return $data;
    }

    /**
     * @param $data
     *
     * @return array|string
     */
    protected function serializeItem($data) {
        if ($data instanceof IArrayable) {
            return $data->toArray();
        } else if ($data instanceof IJsonable) {
            return $data->toJson();
        } else if ($data instanceof IStringable) {
            return $data->toString();
        }

        return $data;
    }
}
