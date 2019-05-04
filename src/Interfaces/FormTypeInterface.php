<?php
/**
 * Created by Fadymichel.
 * git: https://github.com/FadymichelR
 * 2018
 */

namespace Fad\Form\Interfaces;

/**
 * Interface FormTypeInterface
 * @package Fad\Form\Interfaces
 */
interface FormTypeInterface
{

    /**
     * @param FormBuilder $builder
     * @param array $options
     */
    public function buildForm(FormBuilder $builder, array $options = []): void;
}