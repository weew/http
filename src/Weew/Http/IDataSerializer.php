<?php

namespace Weew\Http;

interface IDataSerializer {
    /**
     * @param $data
     *
     * @return mixed
     */
    function serialize($data);
}
