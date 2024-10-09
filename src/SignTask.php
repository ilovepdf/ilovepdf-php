<?php

namespace Ilovepdf;

use Ilovepdf\Exceptions\NotImplementedException;
use Ilovepdf\Exceptions\ProcessException;
use Ilovepdf\File;
use Ilovepdf\Request\Body;
use Ilovepdf\Sign\Receivers\ReceiverAbstract;

/**
 * Class SignTask
 *
 * @package Ilovepdf
 */
class SignTask extends Task
{
    //public $PROCESS_ENDPOINT = 'signature';

    /**
     * @var int
     */
    public $lock_order;

    /**
     * @var int
     */
    public $expiration_days;

    /**
     * @var string
     */
    public $language;

    /**
     * @var string
     */
    public $subject_signer;

    /**
     * @var string
     */
    public $message_signer;

    /**
     * @var array
     */
    public $signers = [];

    /**
     * @var boolean
     */
    public $uuid_visible;

    /**
     * @var int
    */
    public $reminders;

    /**
     * @var boolean
    */
    public $verify_enabled;

    /**
     * @var string
    */
    public $brand_name = null;

    /**
     * @var File
     */
    public $brand_logo = null;

    /**
     * SignatureTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param bool $makeStart Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'sign';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    function addReceiver(ReceiverAbstract $signer)
    {
        $this->signers[] = $signer;
        return $this;
    }

    /**
     * @return string
     */
    public function getVerifySignatureVerification(): bool
    {
        return $this->verify_enabled;
    }

    /**
     * @param bool $verification
     */
    public function setVerifySignatureVerification(bool $verification): SignTask
    {
        $this->verify_enabled = $verification;
        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message_signer;
    }

    /**
     * @param string $subject
     */
    public function setMessage(string $message): SignTask
    {
        $this->message_signer = $message;
        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject_signer;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): SignTask
    {
        $this->subject_signer = $subject;
        return $this;
    }

    public function getReminders(): int
    {
        return $this->reminders;
    }

    /**
     * @param int $days_between
     */
    public function setReminders(int $days_between): SignTask
    {
        $this->reminders = $days_between;
        return $this;
    }

    /**
     * @return int
     */
    public function getLockOrder(): int
    {
        return intval($this->lock_order);
    }

    /**
     * @param int $lock_order
     * @return SignTask
     */
    public function setLockOrder(bool $lock_order): SignTask
    {
        $this->lock_order = intval($lock_order);
        return $this;
    }

    /**
     * @return int
     */
    public function getExpirationDays(): int
    {
        return $this->expiration_days;
    }

    /**
     * @param int $expiration_date
     * @return SignTask
     */
    public function setExpirationDays(int $expiration_days): SignTask
    {
        $this->expiration_days = $expiration_days;
        return $this;
    }
    
    /**
     * @param  string $brandName
     * @param  string $brandLogo
     * @return SignTask
     */
    function setBrand(string $brand_name, File $brand_logo){
        $this->brand_name = $brand_name;
        $this->brand_logo = $brand_logo->server_filename;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return SignTask
     */
    public function setLanguage(string $language): SignTask
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return array
     */
    public function getSigners(): array
    {
        return $this->signers;
    }

    /**
     * @param array $signers
     * @return SignTask
     */
    public function setSigners(array $signers): SignTask
    {
        $this->signers = $signers;
        return $this;
    }

    public function getSignersData(): array
    {
        $data = [];
        foreach ($this->getSigners() as $signer) {
            $data[] = $signer->__toArray();
        }
        return $data;
    }

    /**
     * @return Bool
     */
    public function getUuidVisible(): bool
    {
        return $this->uuid_visible;
    }

    /**
     * @param boolean $uuid_visible
     * @return SignTask
     */
    public function setUuidVisible(bool $uuid_visible): SignTask
    {
        $this->uuid_visible = $uuid_visible;
        return $this;
    }

    public function __toArray()
    {
        $signTaskData = parent::__toArray();
        if(isset($signTaskData["reminders"]) && $signTaskData["reminders"] > 0){
            $signTaskData["signer_reminders"] = true;
            $signTaskData["signer_reminder_days_cycle"] = $signTaskData["reminders"];
            unset($signTaskData["reminders"]);
        }
        $data = array_merge(
            $signTaskData,
            array('signers' => $this->getSignersData())
        );
        return $data;
    }

    /**
     * @param string $filePath
     * @return File
     */
    public function uploadBrandLogo($filePath)
    {
        $file = parent::addFile($filePath);
        if (($key = array_search($file, $this->files)) !== false) {
            unset($this->files[$key]);
        }
        return $file;
    }

    /**
     * @param string $filePath
     * @return File
     */
    public function uploadBrandLogoFromUrl($url, $bearerToken = null)
    {
        $file = parent::addFileFromUrl($url,$bearerToken);
        if (($key = array_search($file, $this->files)) !== false) {
            unset($this->files[$key]);
        }
        return $file;
    }

    /**
     * @return Task
     * @throws Exceptions\AuthException
     * @throws Exceptions\ProcessException
     * @throws Exceptions\UploadException
     */
    public function execute()
    {
        if($this->task===null){
            throw new \Exception('Current task not exists');
        }

        $data = $this->__toArray();

        //clean unwanted vars to be sent
        unset($data['timeoutLarge']);
        unset($data['timeout']);
        unset($data['timeDelay']);

        $body = ['form_params' => $data];
        
        //$response = parent::sendRequest('post', 'signature', http_build_query($body, null, '&', PHP_QUERY_RFC3986));
        $response = parent::sendRequest('post', 'signature', $body,false);
        try {
            $this->result = json_decode($response->getBody()->getContents());
        }
        catch(\Exception $e){
            throw new ProcessException('Bad request');
        }
        return $this;
    }

    /**
     * @param null|string $path
     * @param null|string $file
     */
    public function download($path = null){
        throw new NotImplementedException("This API call is not available for a SignTask");
    }


    /**
     * @param bool $enable
     * @return void
     */
    public function enableEncryption(bool $enable)
    {
        throw new NotImplementedException("This method is not available for a SignTask");
    }

    /**
     * @param string|null $encryptKey
     * @return Task
     */
    public function setFileEncryption(?string $encryptKey = null): Task
    {
        throw new NotImplementedException("This method is not available for a SignTask");
    }
}
