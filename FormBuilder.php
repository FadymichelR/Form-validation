<?php
/**
 * Created by Fadymichel.
 * git: https://github.com/FadymichelR
 * 2018
 */

namespace Fady\Form;


use Fady\Form\Elements\Input;

class FormBuilder extends FormValidator
{
    const METHOD_POST = 'POST';
    const METHOD_GET  = 'GET';

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



    public function __construct($action = '', $method = self::METHOD_POST)
    {
        $this->action = $action;
        $this->method = $method;
    }


    public function __toString()
    {
        $result = $this->getStart();

        foreach ($this->getElements() as $element) {

            $result .= (string)$element;

        }

        $result .= $this->getEnd();

        return $result;
    }

    public function getStart() {

        $result = sprintf('<form method="%s" id="%s" action="%s"', $this->getMethod(), $this->getFormId(), $this->getAction());
        foreach ($this->getAttributes() as $attr => $value) {

            $result .= sprintf(' %s="%s"', $attr, is_bool($value) ? ($value ? 'true' : 'false') : $value);

        }
        $result .= '>';

        return $result;
    }

    public function getEnd() {

        $result = '</form>';
        return $result;
    }


    /**
     * @return string
     */
    public function getFormId()
    {
        return $this->formId === null ? 'form_builder' : $this->formId;
    }

    /**
     * @param mixed $formId
     */
    public function setFormId(string $formId)
    {
        $this->formId = $formId;
        return $this;
    }

    /**
     * @return
     */
    public function getElements()
    {
        return (object)$this->elements;
    }

    /**
     * @param Input $input
     */
    public function add(Input $input, $validator = [])
    {
        if (method_exists($this, 'addField')) {

            $this->addField($input->getName(), $validator);
        }

        $this->elements[$input->getName()] = $input;

        return $this;
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action)
    {
        $this->action = $action;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
        return $this;
    }


}