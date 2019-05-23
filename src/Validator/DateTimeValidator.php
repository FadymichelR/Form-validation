<?php


namespace Fad\Form\Validator;

/**
 * Class ChoiceValidator
 * @package Fad\Form\Validator
 */
class DateTimeValidator extends Validator
{


    private $format = 'Y-m-d H:i:s';

    /**
     * @param $value
     * @return bool
     *
     */
    public function isValid($value): bool
    {
        \DateTime::createFromFormat($this->format, $value);
        $errors = \DateTime::getLastErrors();

        return 0 < $errors['error_count'];
    }

    /**
     * @return string
     */
    public function getFormat(): string
    {
        return $this->format;
    }

    /**
     * @param string $format
     * @return DateTimeValidator
     */
    public function setFormat(string $format): self
    {
        $this->format = $format;
        return $this;
    }


    
}