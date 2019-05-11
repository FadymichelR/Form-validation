<?php
/**
 * Created by Fad.
 * git: https://github.com/FadymichelR
 * 2018
 */

namespace Fad\Form;


use Fad\Form\Traits\Validator;

/**
 * Class FormValidator
 * @package Fad\Form
 */
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
    protected $formErrors = [];

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

    /**
     * @param array $data
     */
    public function submit(array $data): void
    {
        $data = array_map([$this, 'clean'], $data);

        foreach ($data as $field => $value) {

            if (!array_key_exists($field, $this->fields)) {
                $this->addError(null, 'a non-existent field has been submitted');
                continue;
            }

            foreach ($this->fields[$field] as $key => $filter) {

                $option = [];
                if (is_array($filter)) {
                    $option = $filter;
                    $filter = $key;
                }

                if ($this->validateItem($value, $filter, $option) === false) {
                    $this->addError($field,
                        isset($option['message'])
                            ? $option['message']
                            : $this->getDefaultErrorMsg($filter)
                    );
                }
                $this->setData($field, $value);
            }

        }

    }

    /**
     * @param int $type
     * @return string|null
     */
    public function getDefaultErrorMsg(int $type): ? string
    {
        return $this->defaultErrorMsg[$type] ?? null;
    }


    /**
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->isValid;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return string
     */
    public function getError(string $field): string
    {
        return array_key_exists($field, $this->errors) ? $this->errors[$field] : '';
    }

    /**
     * @param string $field
     * @param string $message
     */
    public function addError(?string $field, string $message): self
    {
        if (is_null($field)) {
            $this->formErrors[] = $message;
        }else {
            $this->errors[$field] = $message;
        }

        $this->isValid = false;
        return $this;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $field
     * @param array $filters
     * @return FormValidator
     */
    public function add(string $field, array $filters = []): self
    {
        $this->fields[$field] = $filters;
        return $this;
    }

    /**
     * @param array $fields
     * @return FormValidator
     */
    public function setFields(array $fields): self
    {
        $this->fields = $fields;
        return $this;
    }

    /**
     * @param $value
     * @param int $type
     * @param array $option
     * @return bool|string
     */
    protected function validateItem($value, int $type, array $option = []): bool
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
        return true;
    }

    /**
     * @param $data
     * @return string
     */
    protected function clean($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(string $flied, $value): self
    {
        $this->data[$flied] = $value;
        return $this;
    }

}
