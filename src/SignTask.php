<?php

namespace Ilovepdf;

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
    public $lock_order = 0;

    /**
     * @var int
     */
    public $expiration_days = 90;

    /**
     * @var string
     */
    public $language = 'en';

    /**
     * @var string
     */
    public $subject_signer = null;

    /**
     * @var string
     */
    public $message_signer = null;

    /**
     * @var array
     */
    public $signers = [];

    /**
     * @var boolean
     */
    public $uuid_visible = true;

    /**
     * @var int
    */
    public $reminders = 0;

    /**
     * @var boolean
    */
    public $verify_enabled = true;

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

    protected function getFileData(string $task){
        $data = parent::getFileData($task);
        $data["pdfinfo"] = "1";
        return $data;
    }

    protected function getFileFromResponse($response,$filepath){
        $isPdfFile = substr($filepath, -strlen(".pdf"))=== ".pdf";

        if($isPdfFile){
            $file = new File($response->body->server_filename, basename($filepath));
            $file->setPdfPages($response->body->pdf_pages);
            $file->setPdfPageNumber(intval($response->body->pdf_page_number));
            return $file;
        }
        return parent::getFileFromResponse($response, $filepath);
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
     * @param int $reminders
     */
    public function setReminders(int $reminders): SignTask
    {
        $this->reminders = $reminders;
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
     * @param  File $brandLogo
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

        //$body = Body::multipart($data);
        $body = Body::Json($data);
        
        //$response = parent::sendRequest('post', 'signature', http_build_query($body, null, '&', PHP_QUERY_RFC3986));
        $response = parent::sendRequest('post', 'signature', $body,false,true);

        $this->result = $response->body;

        return $this;
    }
}
