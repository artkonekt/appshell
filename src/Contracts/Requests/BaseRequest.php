<?php
/**
 * Contains the BaseRequest interface.
 *
 * @copyright   Copyright (c) 2017 Attila Fulop
 * @author      Attila Fulop
 * @license     MIT
 * @since       2017-05-24
 *
 */


namespace Konekt\AppShell\Contracts\Requests;


interface BaseRequest
{
    /**
     * Returns the validation rules that apply to the request
     *
     * @return array
     */
    public function rules();

    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize();

    /**
     * Returns the error messages for the defined validation rules
     *
     * @return array
     */
    public function messages();

}