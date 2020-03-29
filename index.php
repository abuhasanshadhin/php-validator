<?php

use App\Validator;

require "./vendor/autoload.php";

echo $validator = new Validator;

$formData = [
    'name' => '',
    'age' => '22',
    'email' => '',
    'phone' => '',
    'url' => 'http://shadhin.com'
];

echo '<pre>';
print_r($validator->make($formData, [
    'name' => 'min:4',
    'email' => 'required|email',
    'url' => 'required|url'
]));



