<?php

namespace Tests\Ilovepdf;

use Ilovepdf\CompressTask;
use Ilovepdf\Ilovepdf;
use PHPUnit\Framework\TestCase;

/**
 * Base class for Stripe test cases, provides some utility methods for creating
 * objects.
 */
class IloveTest extends TestCase
{
    public $publicKey = 'public_key';
    public $secretKey = 'secret_key';


    public $publicKeyTest = "public_key_test";
    public $secretKeyTest = "secret_key_test";

    /**
     * @test
     */
    public function testIlovepdfCreateWithParams()
    {

        $ilovepdf = new Ilovepdf($this->publicKey, $this->secretKey);
        $ilovepdfTest = new Ilovepdf($this->publicKeyTest, $this->secretKeyTest);

        $this->assertEquals($ilovepdf->getPublicKey(), $this->publicKey);
        $this->assertEquals($ilovepdfTest->getPublicKey(), $this->publicKeyTest);
    }

    /**
     * @test
     */
    public function testIlovepdfEmptyParams()
    {
        $ilovepdf = new Ilovepdf();
        $ilovepdfTest = new Ilovepdf();

        $ilovepdf->setApiKeys($this->publicKey, $this->secretKey);
        $ilovepdfTest->setApiKeys($this->publicKeyTest, $this->secretKeyTest);


        $this->assertEquals($ilovepdf->getPublicKey(), $this->publicKey);
        $this->assertEquals($ilovepdfTest->getPublicKey(), $this->publicKeyTest);
    }
}
