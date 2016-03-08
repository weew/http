<?php

namespace Weew\Http;

class ServerGlobal extends SuperGlobal {
    /**
     * ServerGlobal constructor.
     *
     * @param array $server
     */
    public function __construct(array &$server = null) {
        if ($server === null) {
            $server = &$_SERVER;
        }

        parent::__construct($server);
    }
}
