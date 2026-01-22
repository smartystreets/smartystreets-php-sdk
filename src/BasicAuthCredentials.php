<?php

namespace SmartyStreets\PhpSdk;

include_once('Credentials.php');

use InvalidArgumentException;

/**
 * BasicAuthCredentials uses HTTP Basic Authentication (RFC 7617) to send credentials
 * in the Authorization header.
 * <p>Look on the <b>API Keys</b> tab of your SmartyStreets account page to find/generate your keys.</p>
 */
class BasicAuthCredentials implements Credentials {
    private $authId,
            $authToken;

    public function __construct($authId, $authToken) {
        if (empty($authId) || empty($authToken)) {
            throw new InvalidArgumentException('credentials (auth id, auth token) required');
        }
        $this->authId = $authId;
        $this->authToken = $authToken;
    }

    function sign(Request $request) {
        $credentials = base64_encode($this->authId . ':' . $this->authToken);
        $request->setHeader('Authorization', 'Basic ' . $credentials);
    }
}
