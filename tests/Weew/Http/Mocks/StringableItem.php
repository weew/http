<?php

namespace Tests\Weew\Http\Mocks;

use Weew\Foundation\Interfaces\IStringable;

class StringableItem implements IStringable {
    /**
     * @return string
     */
    public function toString() {
        return 'foo';
    }
}
