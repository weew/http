<?php

namespace Tests\Weew\Http\Stubs;

use Weew\Contracts\IStringable;

class StringableItem implements IStringable {
    /**
     * @return string
     */
    public function toString() {
        return 'foo';
    }
}
