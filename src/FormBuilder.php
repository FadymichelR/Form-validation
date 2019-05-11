<?php
/**
 * Created by fad.
 * git: https://github.com/FadymichelR
 * 2018
 */

namespace Fad\Form;

use Fad\Form\Elements\Input;

/**
 * Class FormBuilder
 * @package Fad\Form
 */
class FormBuilder
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';

    private $method = self::METHOD_POST;

    /**
     * @var string
     */
    private $formId = 'form_builder';

    /**
     * @var array
     */
    private $elements = [];

    /**
     * @var string
     */
    private $action;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var array
     */
    private $validations = [];


    /**
     * FormBuilder constructor.
     * @param string $action
     * @param string $method
     */
    public function __construct(string $action = '', string $method = self::METHOD_POST)
    {
        $this->action = $action;
        $this->method = $method;
    }


    /**
     * @return string
     */
    public function __toString(): string
    {
        $result = $this->getStart();

        foreach ($this->getElements() as $element) {
            $result .= (string)$element;
        }

        $result .= $this->getEnd();

        return $result;
    }

    /**
     * @return string
     */
    public function getStart(): string
    {
        $result = sprintf('<form method="%s" id="%s" action="%s"', $this->getMethod(), $this->getFormId(), $this->getAction());

        foreach ($this->getAttributes() as $attr => $value) {
            $result .= sprintf(' %s="%s"', $attr, is_bool($value) ? ($value ? 'true' : 'false') : $value);
        }

        $result .= '>';

        return $result;
    }

    /**
     * @return string
     */
    public function getEnd(): string
    {
        $result = '</form>';
        return $result;
    }


    /**
     * @return string
     */
    public function getFormId(): string
    {
        return $this->formId === null ? 'form_builder' : $this->formId;
    }

    /**
     * @param string $formId
     * @return FormBuilder
     */
    public function setFormId(string $formId): self
    {
        $this->formId = $formId;
        return $this;
    }

    /**
     * @return array
     */
    public function getElements(): array
    {
        return $this->elements;
    }

    /**
     * @param Input $input
     */
    public function add(Input $input, array $validation = []): self
    {
        $this->elements[$input->getName()] = $input;
        $this->validations[$input->getName()] = $validation;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     * @return FormBuilder
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     * @return FormBuilder
     */
    public function setAction(string $action): self
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return FormBuilder
     */
    public function setAttributes(array $attributes): self
    {
        $this->attributes = $attributes;
        return $this;
    }


}