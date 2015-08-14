<?php

namespace Weew\Http;

class CookieBuilder implements ICookieBuilder {
    /**
     * @param ICookie $cookie
     *
     * @return string
     */
    public function build(ICookie $cookie) {
        $string = '';
        $this->writeValue($string, $cookie);
        $this->writeExpires($string, $cookie);
        $this->writePath($string, $cookie);
        $this->writeDomain($string, $cookie);
        $this->writeSecure($string, $cookie);
        $this->writeHttpOnly($string, $cookie);

        return $string;
    }

    /**
     * @param $string
     * @param ICookie $cookie
     */
    protected function writeValue(&$string, ICookie $cookie) {
        $string .= s('%s=%s;', $cookie->getName(), $cookie->getValue());
    }

    /**
     * @param $string
     * @param ICookie $cookie
     */
    private function writeExpires(&$string, ICookie $cookie) {
        if ($cookie->hasMaxAge()) {
            $string .= s(' expires=%s;', $cookie->getExpiresDate());
            $string .= s(' max-age=%s;', $cookie->getMaxAge());
        }
    }

    /**
     * @param $string
     * @param ICookie $cookie
     */
    private function writePath(&$string, ICookie $cookie) {
        $string .= s(' path=%s;', $cookie->getPath());
    }

    /**
     * @param $string
     * @param ICookie $cookie
     */
    private function writeDomain(&$string, ICookie $cookie) {
        if ($cookie->hasDomain()) {
            $string .= s(' domain=%s;', $cookie->getDomain());
        }
    }

    /**
     * @param $string
     * @param ICookie $cookie
     */
    private function writeSecure(&$string, ICookie $cookie) {
        if ($cookie->isSecure()) {
            $string .= ' secure;';
        }
    }

    /**
     * @param $string
     * @param ICookie $cookie
     */
    private function writeHttpOnly(&$string, ICookie $cookie) {
        if ($cookie->isHttpOnly()) {
            $string .= ' httpOnly';
        }
    }
}
