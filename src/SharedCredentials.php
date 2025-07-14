<?php

namespace SmartyStreets\PhpSdk;

include_once('Credentials.php');

/**
 * SharedCredentials is useful if you want to use a website key.
 */
class SharedCredentials implements Credentials {
    private $id,
            $hostname;

    public function __construct($id, $hostname) {
        $this->id = $id;
        $this->hostname = $hostname;
    }

    function sign(Request $request) {
        $request->setParameter("key", $this->id);
        $request->setHeader('Referer', 'referer:https://' . $this->hostname);
    }
}