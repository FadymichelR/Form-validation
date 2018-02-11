<?php
/**
 * Created by PhpStorm.
 * User: fadymichel
 * Date: 09/02/18
 * Time: 20:04
 */

namespace Fady\Form\Elements;


class Input
{

    const HTML_ELEMENT = 'input';

    const TEXT = 'text';
    const EMAIL = 'email';
    const HIDDEN = 'hidden';
    const PASSWORD = 'password';
    const RADIO = 'radio';
    const CHECKBOX = 'checkbox';
    const DATE = 'date';
    const NUMBER = 'number';
    const TEL = 'tel';
    const SUBMIT = 'submit';


    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $options = [];

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $label;

    /**
     * @var array
     */
    private $radios = [];


    /**
     * Input constructor.
     * @param $name
     * @param $type
     * @param array $options
     */
    public function __construct($name, $type, array $options = [])
    {
        $this->name = $name;
        $this->type = $type;
        $this->label = isset($options['label']) ? $options['label'] : $name;
        $this->options = $options;
        if ($this->getType() === Input::RADIO) {

            foreach ($this->getOptions() as $input => $options) {

                $this->addRadio($this->generateHtml($options));
            }
        }

    }

    /**
     * @return string
     */
    public function __toString()
    {
        $result = '';
        if ($this->getType() === Input::RADIO) {

            foreach ($this->getOptions() as $input => $options) {

                $result .= $this->generateHtml($options);
            }
        } else {
            $result = $this->generateHtml($this->getOptions());
        }
        return $result;
    }


    /**
     * @param $id
     * @return mixed|null
     */
    public function getRadio($id)
    {
        if ($this->getType() === Input::RADIO) {

            return array_key_exists($id,  $this->radios) ? $this->radios[$id] : null;
        }
        return null;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }


    /**
     * @param $radio
     */
    public function addRadio($radio)
    {
        $this->radios[] = $radio;
    }

    public function generateHtml($options = [])
    {

        $result = sprintf('<%s type="%s" name="%s"', self::HTML_ELEMENT, $this->getType(), $this->getName());

        foreach ($options as $attr => $value) {

            if ($value !== false) {

                $result .= sprintf(' %s="%s"', $attr, is_bool($value) ? '' : $value);
            }

        }

        if (!strpos($result, 'value') && $_SERVER["REQUEST_METHOD"] == "POST") {
            $value = isset($_POST[$this->getName()]) ? $_POST[$this->getName()] : '';
            $result .= sprintf(' value="%s"', $value);
        }
        $result .= '>';

        return $result;
    }

}