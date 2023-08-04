<?php

namespace App\Helper;

class FormHelper {
    
    public function getFormErrors($form): array
    {
        $errors = [];

        foreach ($form->getErrors(true, true) as $error) {
            // Get the name of the form field that has the error
            $fieldName = $error->getOrigin()->getName();

            $errorMessage = $error->getMessage();

            $errors[$fieldName][] = $errorMessage;
        }

        foreach ($form->all() as $name => $child) {
            foreach ($child->getErrors(true, true) as $error) {
                $errors[$name][] = $error->getMessage();
            }
        }
    

        return $errors;
    }

}