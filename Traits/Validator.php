<?php
/**
 * Created by Fadymichel.
 * git: https://github.com/FadymichelR
 * 2018
 */

namespace Fady\Form\Traits;


trait Validator
{

    /**
     * @param $email
     * @return mixed
     */
    public function isEmail($email)
    {

        return filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : false;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isAlnum($value)
    {
        return ctype_alnum($value) ? $value : false;
    }


    /**
     * @param $value
     * @return bool
     */
    public function choice($value, $option)
    {
        return in_array($value, $option) ? $value : false;
    }


    /**
     * @param $value
     * @param null $option
     * @return bool
     */
    public function validStrLen($value, $option = null)
    {

        $min = $option ? $option['min'] : null;
        $max = $option ? $option['max'] : null;

        $len = strlen($value);
        if ($len < $min && !is_null($min)) {
            return false;
        } elseif ($len > $max && !is_null($max)) {
            return false;
        }
        return $value;

    }

    /**
     * @param $int
     * @return bool
     */
    public function isInt($int, $option = null)
    {

        if (is_numeric($int)) {

            $int = (int)$int;
            return filter_var($int, FILTER_VALIDATE_INT, $option ? $options = [
                'options' => $option
            ] : FILTER_FLAG_ALLOW_OCTAL) ? $int : false;
        }
        return false;
    }

    /**
     * @param $date
     * @return bool|string
     */
    public function isDate($date, $option = null)
    {
        $format = $option ? $option['format'] : 'd-m-Y';

        return $this->createDateTime($date, $format);
    }

    /**
     * @param $time
     * @return bool|string
     */
    public function isTime($time, $option = null)
    {
        $format = $option ? $option['format'] : 'h:i';
        return $this->createDateTime($time, $format);
    }

    /**
     * @param $dateOrTime
     * @param string $format
     * @return bool|\DateTime
     */
    public function createDateTime($dateOrTime, $format = 'm-d-Y h:i') {

        try {
            $dateTime = new \DateTime();
            $dateOrTime = $dateTime->createFromFormat($format, $dateOrTime);
            return $dateOrTime instanceof \DateTime ? $dateOrTime : false;

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $value
     * @return bool
     */
    public function isRequired($value)
    {

        return !empty($value) ? $value : false;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isNumeric($value)
    {
        return is_numeric($value) ? $value : false;
    }

}