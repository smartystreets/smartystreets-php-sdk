<?php

namespace SmartyStreets;

include_once('Credentials.php');

class StaticCredentials implements Credentials {
    private $authId,
            $authToken;

    public function __construct($authId, $authToken) {
        $this->authId = $authId;
        $this->authToken = $authToken;
    }

    function sign(Request $request) {
        $request->setParameter("auth-id", $this->authId);
        $request->setParameter("auth-token", $this->authToken);
    }
}