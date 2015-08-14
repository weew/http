<?php

namespace Tests\Weew\Http\Stubs;

use Weew\Foundation\Interfaces\IJsonable;

class JsonableItem implements IJsonable {
    private $id;
    public function __construct($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }
    public function toJson($options = 0) {
        return json_encode(['id' => $this->id], $options);
    }
}
