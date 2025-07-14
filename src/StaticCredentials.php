<?php

namespace SmartyStreets\PhpSdk;

include_once('Credentials.php');

/**
 * StaticCredentials takes a SmartyStreets Secret Key Pair, and 'signs' the request with it so the<br>
 * SmartyStreets API knows which SmartyStreets account and subscription is sending it.
 * <p>Look on the <b>API Keys</b> tab of your SmartyStreets account page to find/generate your keys.</p>
 */
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