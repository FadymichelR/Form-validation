# Formvalidation
A simple form validation in PHP

Easy to use:

``` php
<?php
require 'FormValidator.php';
/**
 * @var FormValidator $validator
 */
$form = new FormValidator();
$form
    ->addField('firstName', [
        FormValidator::REQUIRED,
        FormValidator::LENGTH => [
            'min' => 3,
            'max' => 30
        ]
    ])
    ->addField('lastName', [
        FormValidator::REQUIRED,
        FormValidator::LENGTH => [
            'min' => 3,
            'max' => 30
        ]
    ])
    ->addField('mail', [
        FormValidator::REQUIRED,
        FormValidator::EMAIL,
    ])
    ->addField('phone', [
        FormValidator::REQUIRED,
        FormValidator::PHONE
    ])
    ->addField('passengers', [
        FormValidator::REQUIRED,
        FormValidator::INT => [
            'min_range' => 0,
            'max_range' => $reservation->getCar()->getPlaces()
        ]
    ])
    ->addField('vol', [
        FormValidator::REQUIRED,
        FormValidator::ALPHANUMERIC,
    ])
    ->addField('methodPayment', [
        FormValidator::REQUIRED,
        FormValidator::CHOICE => [
            Reservation::PAYMENT_CASH,
            Reservation::PAYMENT_CARD,
        ]
    ]);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $form->validate($_POST);
      if ($form->isValid()) {
        // save
      } else {
        // return array
        $form->getErrors()
      }
      
    }
    ```
