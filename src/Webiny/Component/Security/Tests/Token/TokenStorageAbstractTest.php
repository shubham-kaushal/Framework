<?php
/**
 * Webiny Framework (http://www.webiny.com/framework)
 *
 * @copyright Copyright Webiny LTD
 */

namespace Webiny\Component\Security\Tests\Token;

use Webiny\Component\Config\ConfigObject;
use Webiny\Component\Security\Role\Role;
use Webiny\Component\Security\Tests\Mocks\TokenCryptMock;
use Webiny\Component\Security\Tests\Mocks\TokenStorageMock;
use Webiny\Component\Security\Tests\Mocks\UserMock;
use Webiny\Component\Security\Token\AbstractTokenStorage;
use Webiny\Component\Security\Token\CryptDrivers\CryptDriverInterface;
use Webiny\Component\Security\Token\TokenData;

class TokenStorageAbstractTest extends \PHPUnit_Framework_TestCase
{

    public function testConstructor()
    {
        $instance = new TokenStorageMock();
        $this->assertInstanceOf(AbstractTokenStorage::class, $instance);
    }

    public function testSetGetTokenName()
    {
        $instance = new TokenStorageMock();
        $instance->setTokenName('TName');
        $this->assertSame('TName', $instance->getTokenName());
    }

    public function testSetGetCrypt()
    {
        $instance = new TokenStorageMock();
        $crypt = new TokenCryptMock(new ConfigObject([]));

        $instance->setCrypt($crypt);
        $this->assertInstanceOf(CryptDriverInterface::class, $instance->getCrypt());
        $this->assertInstanceOf(TokenCryptMock::class, $instance->getCrypt());
    }

    public function testEncryptUserData()
    {
        \Webiny\Component\Crypt\Crypt::setConfig(__DIR__ . '/CryptDrivers/Crypt/CryptExampleConfig.yaml');

        $user = new UserMock();
        $user->populate('uname', 'pwd', [new Role('ROLE_MOCK')], false);

        $crypt = new TokenCryptMock(new ConfigObject([]));

        $instance = new TokenStorageMock();
        $instance->setCrypt($crypt);

        $result = $instance->encryptUserData($user);

        // validate the result
        $result = json_decode($result, true);
        $this->assertSame("uname", $result['u']);
    }

    public function testDecryptUserData()
    {
        \Webiny\Component\Crypt\Crypt::setConfig(__DIR__ . '/CryptDrivers/Crypt/CryptExampleConfig.yaml');

        $user = new UserMock();
        $user->populate('uname', 'pwd', [new Role('ROLE_MOCK')], false);

        $crypt = new TokenCryptMock(new ConfigObject([]));

        $instance = new TokenStorageMock();
        $instance->setCrypt($crypt);

        $result = $instance->encryptUserData($user);

        $tokenData = $instance->decryptUserData($result);
        $this->assertInstanceOf(TokenData::class, $tokenData);
        $this->assertSame('uname', $tokenData->getUsername());
    }
}