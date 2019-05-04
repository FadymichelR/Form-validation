<?php
/**
 * Created by PhpStorm.
 * User: Fad
 * Date: 09/02/18
 * Time: 20:04
 */

namespace Fad\Form\Elements;

/**
 * Class Input
 * @package Fad\Form\Elements
 */
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
    public function __construct(string $name, string $type, array $options = [])
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
    public function __toString(): string
    {
        $result = '';
        if ($this->getType() === Input::RADIO) {
            foreach ($this->getOptions() as $input => $options) {
                $result .= $this->generateHtml($options);
            }
            return $result;
        }
        return $this->generateHtml($this->getOptions());
    }


    /***
     * @param string $id
     * @return string|null
     */
    public function getRadio(string $id): ?string
    {
        if ($this->getType() === Input::RADIO) {
            return array_key_exists($id, $this->radios) ? $this->radios[$id] : null;
        }
        return null;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Input
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }


    /**
     * @param string $radio
     * @return Input
     */
    public function addRadio(string $radio) :self
    {
        $this->radios[] = $radio;
        return $this;
    }

    /**
     * @param array $options
     * @return string
     */
    public function generateHtml(array $options = []): string
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