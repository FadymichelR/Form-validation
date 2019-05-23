<?php


namespace Fad\Form\Validator;

/**
 * Class ChoiceValidator
 * @package Fad\Form\Validator
 */
class ChoiceValidator extends Validator
{


    private $choices = [];

    /**
     * @param $value
     * @return bool
     *
     */
    public function isValid($value): bool
    {
        return in_array($value, $this->choices);
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /**
     * @param array $choices
     * @return ChoiceValidator
     */
    public function setChoices(array $choices): self
    {
        $this->choices = $choices;
        return $this;
    }



}