<?php

namespace App\Traits;


trait APITrait
{    
    /**
     * getAPIErrors
     *
     * @param  mixed $validator
     * @param  mixed $fields
     * @return array
     */
    public function getAPIErrors($validator, $fields): Array
    {
        $messages = $validator->messages();

        $errors = [];
        foreach($fields as $k=>$v){

            if ($messages->has($k)){

                $errors[$k] = $messages->first($k, '');
            }else{
                $errors[$k] = "";
            }
        }
        return $errors;
    }
}