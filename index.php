<?php

use App\Validator;

require "./vendor/autoload.php";

echo $validator = new Validator;

$formData = [
    'name' => 'shadhin',
    'age' => '22',
    'email' => 'shadhin@gmail.com',
    'phone' => '',
    'url' => 'http://shadhin.com'
];

echo '<pre>';
print_r($validator->make($formData, [
    'name' => 'required|string|min:5|max:7',
    'age' => 'required|min:25|numeric',
    'email' => 'required|email',
    'phone' => 'numeric|min:11',
    'url' => 'required|url'
]));



