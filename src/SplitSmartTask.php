<?php

namespace Ilovepdf;


use Ilovepdf\Exceptions\InvalidParamsException;

/**
 * Class SplitSmartTask
 *
 * @package Ilovepdf
 */
class SplitSmartTask extends Task
{
    /**
     * @var string|null
     */
    public $split_mode;


    /**
     * @var string
     */
    public $prompt;

    /**
     * SplitTask constructor.
     *
     * @param null|string $publicKey Your public key
     * @param null|string $secretKey Your secret key
     * @param bool $makeStart Set to false for chained tasks, because we don't need the start
     */
    function __construct($publicKey, $secretKey, $makeStart = true)
    {
        $this->tool = 'splitsmart';
        $this->split_mode = 'auto';
        parent::__construct($publicKey, $secretKey, $makeStart);
    }

    function setPrompt(string $prompt): self
    {
        $this->prompt = $prompt;
        return $this;
    }

    function validate(): void
    {
        // Check if prompt is empty
        if ($this->prompt === null || $this->prompt === '') {
            throw new InvalidParamsException('Prompt is empty');
        }

        parent::validate();
    }
}
