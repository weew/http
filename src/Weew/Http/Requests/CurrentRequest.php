<?php

namespace Weew\Http\Requests;

use Weew\Http\HttpRequest;
use Weew\Http\IReceivedRequestParser;
use Weew\Http\ReceivedRequestParser;

class CurrentRequest extends HttpRequest {
    /**
     * @param array|null $server
     * @param IReceivedRequestParser|null $parser
     */
    public function __construct(array $server = null, IReceivedRequestParser $parser = null) {
        parent::__construct();

        if ($server === null) {
            $server = $_SERVER;
        }

        if ($parser === null) {
            $parser = $this->createParser();
        }

        $parser->parseRequest($server, $this);
    }

    /**
     * @return ReceivedRequestParser
     */
    protected function createParser() {
        return new ReceivedRequestParser();
    }
}
