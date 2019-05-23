<?php


namespace Fad\Form\Validator;


/**
 * Class Validator
 * @package Fad\Form\Validator
 */
abstract class Validator
{

    /**
     * @var string
     */
    private $message;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Validator
     */
    public function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param $value
     * @return bool
     *
     */
    abstract public function isValid($value): bool;

}