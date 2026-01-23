<?php

namespace SmartyStreets\PhpSdk\Tests;

require_once(dirname(dirname(__FILE__)) . '/src/Request.php');
require_once(dirname(dirname(__FILE__)) . '/src/BasicAuthCredentials.php');
use SmartyStreets\PhpSdk\Request;
use SmartyStreets\PhpSdk\BasicAuthCredentials;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class BasicAuthCredentialsTest extends TestCase {
    public function testNewBasicAuthCredentialWithValidCredentials() {
        $cred = new BasicAuthCredentials('testID', 'testToken');

        $this->assertNotNull($cred);
    }

    public function testNewBasicAuthCredentialWithEmptyAuthID() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('credentials (auth id, auth token) required');

        new BasicAuthCredentials('', 'testToken');
    }

    public function testNewBasicAuthCredentialWithEmptyAuthToken() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('credentials (auth id, auth token) required');

        new BasicAuthCredentials('testID', '');
    }

    public function testNewBasicAuthCredentialWithBothEmpty() {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('credentials (auth id, auth token) required');

        new BasicAuthCredentials('', '');
    }

    public function testNewBasicAuthCredentialWithSpecialCharacters() {
        $cred = new BasicAuthCredentials('test@id#123', 'token!@#$%^&*()');

        $this->assertNotNull($cred);
    }

    public function testSignWithValidCredentials() {
        $cred = new BasicAuthCredentials('myID', 'myToken');
        $request = new Request();

        $cred->sign($request);

        $headers = $request->getHeaders();
        $this->assertArrayHasKey('Authorization', $headers);

        $expectedAuth = 'Basic ' . base64_encode('myID:myToken');
        $this->assertEquals($expectedAuth, $headers['Authorization']);
    }

    public function testSignWithPasswordContainingColon() {
        $cred = new BasicAuthCredentials('validUserID', 'password:with:colons');
        $request = new Request();

        $cred->sign($request);

        $headers = $request->getHeaders();
        $expectedAuth = 'Basic ' . base64_encode('validUserID:password:with:colons');
        $this->assertEquals($expectedAuth, $headers['Authorization']);
    }

    public function testSignWithSpecialCharacters() {
        $cred = new BasicAuthCredentials('user@domain.com', 'p@ssw0rd!');
        $request = new Request();

        $cred->sign($request);

        $headers = $request->getHeaders();
        $expectedAuth = 'Basic ' . base64_encode('user@domain.com:p@ssw0rd!');
        $this->assertEquals($expectedAuth, $headers['Authorization']);
    }

    public function testSignWithUnicodeCharacters() {
        $cred = new BasicAuthCredentials('用户', '密码');
        $request = new Request();

        $cred->sign($request);

        $headers = $request->getHeaders();
        $expectedAuth = 'Basic ' . base64_encode('用户:密码');
        $this->assertEquals($expectedAuth, $headers['Authorization']);
    }

    public function testSignOverwritesExistingHeader() {
        $cred = new BasicAuthCredentials('newID', 'newToken');
        $request = new Request();
        $request->setHeader('Authorization', 'Bearer oldtoken');

        $cred->sign($request);

        $headers = $request->getHeaders();
        $expectedAuth = 'Basic ' . base64_encode('newID:newToken');
        $this->assertEquals($expectedAuth, $headers['Authorization']);
    }
}
