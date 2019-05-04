<?php
/**
 * Created by fad.
 * git: https://github.com/FadymichelR
 * 2018
 */

namespace Fad\Form\Traits;

/**
 * Trait Validator
 * @package Fad\Form\Traits
 */
trait Validator
{

    /**
     * @param $email
     * @return bool
     */
    public function isEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isAlNum($value): bool
    {
        return ctype_alnum($value);
    }


    /**
     * @param $value
     * @return bool
     */
    public function choice($value, $option): bool
    {
        return in_array($value, $option);
    }


    /**
     * @param $value
     * @param null $option
     * @return bool
     */
    public function validStrLen($value, array $option = []): bool
    {

        $min = !empty($option) ? $option['min'] : null;
        $max = !empty($option) ? $option['max'] : null;

        $len = strlen($value);
        if ($len < $min && !is_null($min)) {
            return false;
        } elseif ($len > $max && !is_null($max)) {
            return false;
        }
        return true;

    }

    /**
     * @param $int
     * @return bool
     */
    public function isInt($int, $option = null): bool
    {

        if (is_numeric($int)) {
            $int = (int)$int;
            return filter_var($int, FILTER_VALIDATE_INT, $option ? $options = [
                'options' => $option
            ] : FILTER_FLAG_ALLOW_OCTAL);
        }
        return false;
    }

    /**
     * @param $date
     * @return bool
     */
    public function isDate(string $date, array $option = []): bool
    {
        $format = !empty($option) ? $option['format'] : 'd-m-Y';
        return $this->createDateTime($date, $format);
    }

    /**
     * @param $time
     * @return bool
     */
    public function isTime(string $time, array $option = []): bool
    {
        $format = !empty($option) ? $option['format'] : 'h:i';
        return $this->createDateTime($time, $format);
    }

    /**
     * @param $dateOrTime
     * @param string $format
     * @return bool|\DateTime
     */
    public function createDateTime(string $dateOrTime, $format = 'm-d-Y h:i'): bool
    {
        try {
            $dateTime = new \DateTime();
            return $dateTime->createFromFormat($format, $dateOrTime) instanceof \DateTime;
        } catch (\Exception $e) {
        }
        return false;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isRequired(string $value): bool
    {
        return !empty($value);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isNumeric($value): bool
    {
        return is_numeric($value);
    }

}