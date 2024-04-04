<?php

namespace Ilovepdf;
/**
 * Class ProtectTask
 *
 * @package Ilovepdf
 */
class ProtectTask extends Task
{

    /**
     * @var string|null
     */
    public $password;
    /**
     * @var string|null
     */
    public $owner_password;

    public $allow_print = true;
    public $allow_modify = true;
    public $allow_copy = true;
    public $allow_annotate = true;
    public $allow_fill = true;
    public $allow_accessibility = true;
    public $allow_assemble = true;
    public $keep_original = false;
    public $allow_nothing = false;

    /**
     * UnlockTask constructor.
     *
     * @param null|string $publicKey    Your public key
     * @param null|string $secretKey    Your secret key
     * @param bool $makeStart           Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'protect';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @param string $owner_password
     * @return $this
     */
    public function setOwnerPassword(string $owner_password): self
    {
        $this->owner_password = $owner_password;
        return $this;
    }

    /**
     * @param bool $allow_print
     * @return $this
     */
    public function setAllowPrint(bool $allow_print): self
    {
        $this->allow_print = $allow_print;
        return $this;
    }

    /**
     * @param bool $allow_modify
     * @return $this
     */
    public function setAllowModify(bool $allow_modify): self
    {
        $this->allow_modify = $allow_modify;
        return $this;
    }

    /**
     * @param bool $allow_copy
     * @return $this
     */
    public function setAllowCopy(bool $allow_copy): self
    {
        $this->allow_copy = $allow_copy;
        return $this;
    }

    /**
     * @param bool $allow_annotate
     * @return $this
     */
    public function setAllowAnnotate(bool $allow_annotate): self
    {
        $this->allow_annotate = $allow_annotate;
        return $this;
    }

    /**
     * @param bool $allow_fill
     * @return $this
     */
    public function setAllowFill(bool $allow_fill): self
    {
        $this->allow_fill = $allow_fill;
        return $this;
    }

    /**
     * @param bool $allow_accessibility
     * @return $this
     */
    public function setAllowAccessibility(bool $allow_accessibility): self
    {
        $this->allow_accessibility = $allow_accessibility;
        return $this;
    }

    /**
     * @param bool $allow_assemble
     * @return $this
     */
    public function setAllowAssemble(bool $allow_assemble): self
    {
        $this->allow_assemble = $allow_assemble;
        return $this;
    }

    /**
     * @param bool $keep_original
     * @return $this
     */
    public function setKeepOriginal(bool $keep_original): self
    {
        $this->keep_original = $keep_original;
        return $this;
    }

    /**
     * @param bool $allow_nothing
     * @return $this
     */
    public function setAllowNothing(bool $allow_nothing): self
    {
        $this->allow_nothing = $allow_nothing;
        return $this;
    }
}
