<?php
/**
 * Created by Fadymichel.
 * git: https://github.com/FadymichelR
 * 2018
 */

namespace Fady\Form;


use Fady\Form\Traits\Validator;

class FormValidator
{

    use Validator;

    const REQUIRED = 1;
    const INT = 3;
    const EMAIL = 4;
    const NUMBER = 5;
    const DATE = 6;
    const TIME = 7;
    const LENGTH = 8;
    const ALPHANUMERIC = 9;
    const CHOICE = 10;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var array
     */
    protected $fields = [];

    /**
     * @var bool
     */
    protected $isValid = true;

    /**
     * @var array
     */
    protected $defaultErrorMsg = [
        self::REQUIRED => "This field must be filled in",
        self::INT => "Positive integer value is required",
        self::EMAIL => "Invalid e-mail address format",
        self::NUMBER => "Number is required",
        self::DATE => "This value is not a valid date",
        self::TIME => "This value is not a valid time",
        self::LENGTH => "the number of characters must be between %s and %s",
        self::ALPHANUMERIC => "all characters must be alphanumeric",
        self::CHOICE => "incorrect value"
    ];

    /**
     * @var array
     */
    protected $data = [];


    public function validate(array $data)
    {
        $data = array_map([$this, 'clean'], $data);

        foreach ($data as $field => $value) {

            if (array_key_exists($field, $this->fields)) {

                foreach ($this->fields[$field] as $key => $filter) {

                    $option = null;
                    if (is_array($filter)) {
                        $option = $filter;
                        $filter = $key;
                    }
                    $response = $this->validateItem($value, $filter, $option);
                    if ($response === false) {

                        $this->addError(
                            $field,
                            isset($option['message'])
                                ? $option['message']
                                : $this->getDefaultErrorMsg($filter)
                        );
                    } else {
                        $this->setData($field, $response);
                    }
                }
            }
        }

    }

    /**
     * @return array
     */
    public function getDefaultErrorMsg($type)
    {
        return $this->defaultErrorMsg[$type] ?: null;
    }


    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getError($field)
    {
        return array_key_exists($field, $this->errors) ? $this->errors[$field] : '';
    }

    /**
     * @param $field
     * @param $message
     */
    public function addError($field, $message)
    {
        $this->errors[$field] = $message;
        $this->isValid = false;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @param $field
     * @param null $rule
     * @return $this
     */
    public function addField($field, array $filters = [])
    {
        $this->fields[$field] = $filters;
        return $this;
    }


    public function validateItem($value, $type, $option = null)
    {
        switch ($type) {
            case self::REQUIRED:
                return $this->isRequired($value);
                break;
            case self::DATE:
                return $this->isDate($value, $option);
                break;
            case self::TIME:
                return $this->isTime($value, $option);
                break;
            case self::EMAIL:
                return $this->isEmail($value);
                break;
            case self::INT:
                return $this->isInt($value, $option);
                break;
            case self::LENGTH:
                return $this->validStrLen($value, $option);
                break;
            case self::CHOICE:
                return $this->choice($value, $option);
                break;
            case self::ALPHANUMERIC:
                return $this->isAlnum($value);
                break;
            case self::NUMBER:
                return $this->isNumeric($value);
                break;
        }
        return $value;
    }

    public function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($flied, $value)
    {
        $this->data[$flied] = $value;
    }

}
