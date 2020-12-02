<?php

namespace Tests\Ilovepdf;

use Ilovepdf\Ilovepdf;
use PHPUnit\Framework\TestCase;

class IlovepdfTest extends TestCase
{

    public $ilovepdf;

    public $publicKey = "public_key";
    public $secretKey = "secret_key";

    public function setUp(): void
    {
        $this->ilovepdf = new Ilovepdf();
        $this->ilovepdf->setApiKeys($this->publicKey, $this->secretKey);
    }

    /**
     * @test
     */
    public function testShouldHaveSecretKey()
    {
        $secretKey = $this->ilovepdf->getSecretKey();
        $this->assertEquals($this->secretKey, $secretKey);
    }

    /**
     * @test
     */
    public function testShouldHavePublictKey()
    {
        $publicKey = $this->ilovepdf->getPublicKey();
        $this->assertEquals($this->publicKey, $publicKey);
    }

    /**
     * @test
     */
    public function testCanSetApiKeys()
    {
        $public = "public";
        $secret = "private";
        $this->ilovepdf->setApiKeys($public, $secret);
        $this->assertEquals($public, $this->ilovepdf->getPublicKey());
        $this->assertEquals($secret, $this->ilovepdf->getSecretKey());
    }

    /**
     * @test
     */
    public function testCanGetJwt()
    {
        $jwt = $this->ilovepdf->getJWT();
        $this->assertNotNull($jwt, "jwt should not be null");
    }

    /**
     * @test
     * @expectedException \Exception
     */
    public function testEmptyTaskShouldThrowException()
    {
        $this->expectException(\Exception::class);
        $task = $this->ilovepdf->newTask("");
        $this->assertNotNull($task);
    }

    /**
     * @test
     * @expectedException \InvalidArgumentException
     */
    public function testNotExistingTaskShouldThrowException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->ilovepdf->newTask("tralara");
    }

    /**
     * @test
     */
    public function testEncryptSetDefaultKey()
    {
        $this->ilovepdf->setFileEncryption(true);
        $this->assertNotNull($this->ilovepdf->getEncrytKey());
        $this->assertEquals(strlen($this->ilovepdf->getEncrytKey()), 32);
    }


    /**
     * @test
     */
    public function testCanSetEncrypt()
    {
        $key = '1234123412341234';
        $this->ilovepdf->setFileEncryption(true, $key );
        $this->assertEquals($this->ilovepdf->getEncrytKey(), $key);
    }

    /**
     * @test
     */
    public function testUnsetEncryptRemovesKey()
    {
        $key = '1234123412341234';
        $this->ilovepdf->setFileEncryption(true, $key );
        $this->ilovepdf->setFileEncryption(false);
        $this->assertNull($this->ilovepdf->getEncrytKey());
    }


    /**
     * @test
     * @dataProvider invalidKeys
     * @expectedException \InvalidArgumentException
     */
    public function testWrongEncryptKeyThrowsException($key)
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->ilovepdf->setFileEncryption(true, $key );
    }


    public function invalidKeys()
    {
        return [
            ['1234'],
            ['asdfqwe'],
        ];
    }
}