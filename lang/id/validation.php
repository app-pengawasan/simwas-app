<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Isian :attribute harus be accepted.',
    'accepted_if' => 'Isian :attribute harus be accepted when :other is :value.',
    'active_url' => 'Isian :attribute is not a valid URL.',
    'after' => 'Isian :attribute harus be a date after :date.',
    'after_or_equal' => 'Isian :attribute harus be a date after or equal to :date.',
    'alpha' => 'Isian :attribute harus only contain letters.',
    'alpha_dash' => 'Isian :attribute harus only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'Isian :attribute harus only contain letters and numbers.',
    'array' => 'Isian :attribute harus be an array.',
    'before' => 'Isian :attribute harus be a date before :date.',
    'before_or_equal' => 'Isian :attribute harus be a date before or equal to :date.',
    'between' => [
        'array' => 'Isian :attribute harus have between :min and :max items.',
        'file' => 'Isian :attribute harus be between :min and :max kilobytes.',
        'numeric' => 'Isian :attribute harus be between :min and :max.',
        'string' => 'Isian :attribute harus be between :min and :max characters.',
    ],
    'boolean' => 'Isian :attribute field harus be true or false.',
    'confirmed' => 'Isian :attribute confirmation does not match.',
    'current_password' => 'Isian password is incorrect.',
    'date' => 'Isian :attribute is not a valid date.',
    'date_equals' => 'Isian :attribute harus be a date equal to :date.',
    'date_format' => 'Isian :attribute does not match the format :format.',
    'declined' => 'Isian :attribute harus be declined.',
    'declined_if' => 'Isian :attribute harus be declined when :other is :value.',
    'different' => 'Isian :attribute and :other harus be different.',
    'digits' => 'Isian :attribute harus be :digits digits.',
    'digits_between' => 'Isian :attribute harus be between :min and :max digits.',
    'dimensions' => 'Isian :attribute has invalid image dimensions.',
    'distinct' => 'Isian :attribute field has a duplicate value.',
    'doesnt_start_with' => 'Isian :attribute may not start with one of the following: :values.',
    'email' => 'Isian :attribute harus be a valid email address.',
    'ends_with' => 'Isian :attribute harus end with one of the following: :values.',
    'enum' => 'Isian selected :attribute is invalid.',
    'exists' => 'Isian selected :attribute is invalid.',
    'file' => 'Isian :attribute harus be a file.',
    'filled' => 'Isian :attribute field harus have a value.',
    'gt' => [
        'array' => 'Isian :attribute harus have more than :value items.',
        'file' => 'Isian :attribute harus be greater than :value kilobytes.',
        'numeric' => 'Isian :attribute harus be greater than :value.',
        'string' => 'Isian :attribute harus be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'Isian :attribute harus have :value items or more.',
        'file' => 'Isian :attribute harus be greater than or equal to :value kilobytes.',
        'numeric' => 'Isian :attribute harus be greater than or equal to :value.',
        'string' => 'Isian :attribute harus be greater than or equal to :value characters.',
    ],
    'image' => 'Isian :attribute harus be an image.',
    'in' => 'Isian selected :attribute is invalid.',
    'in_array' => 'Isian :attribute field does not exist in :other.',
    'integer' => 'Isian :attribute harus be an integer.',
    'ip' => 'Isian :attribute harus be a valid IP address.',
    'ipv4' => 'Isian :attribute harus be a valid IPv4 address.',
    'ipv6' => 'Isian :attribute harus be a valid IPv6 address.',
    'json' => 'Isian :attribute harus be a valid JSON string.',
    'lt' => [
        'array' => 'Isian :attribute harus have less than :value items.',
        'file' => 'Isian :attribute harus be less than :value kilobytes.',
        'numeric' => 'Isian :attribute harus be less than :value.',
        'string' => 'Isian :attribute harus be less than :value characters.',
    ],
    'lte' => [
        'array' => 'Isian :attribute harus not have more than :value items.',
        'file' => 'Isian :attribute harus be less than or equal to :value kilobytes.',
        'numeric' => 'Isian :attribute harus be less than or equal to :value.',
        'string' => 'Isian :attribute harus be less than or equal to :value characters.',
    ],
    'mac_address' => 'Isian :attribute harus be a valid MAC address.',
    'max' => [
        'array' => 'Isian :attribute harus not have more than :max items.',
        'file' => 'Isian :attribute harus not be greater than :max kilobytes.',
        'numeric' => 'Isian :attribute harus not be greater than :max.',
        'string' => 'Isian :attribute harus not be greater than :max characters.',
    ],
    'mimes' => 'Isian :attribute harus be a file of type: :values.',
    'mimetypes' => 'Isian :attribute harus be a file of type: :values.',
    'min' => [
        'array' => 'Isian :attribute harus have at least :min items.',
        'file' => 'Isian :attribute harus be at least :min kilobytes.',
        'numeric' => 'Isian :attribute harus be at least :min.',
        'string' => 'Isian :attribute harus minimal :min karakter.',
    ],
    'multiple_of' => 'Isian :attribute harus be a multiple of :value.',
    'not_in' => 'Isian selected :attribute is invalid.',
    'not_regex' => 'Isian :attribute format is invalid.',
    'numeric' => 'Isian :attribute harus be a number.',
    'password' => [
        'letters' => 'Isian :attribute harus contain at least one letter.',
        'mixed' => 'Isian :attribute harus contain at least one uppercase and one lowercase letter.',
        'numbers' => 'Isian :attribute harus contain at least one number.',
        'symbols' => 'Isian :attribute harus contain at least one symbol.',
        'uncompromised' => 'Isian given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'Isian :attribute field harus be present.',
    'prohibited' => 'Isian :attribute field is prohibited.',
    'prohibited_if' => 'Isian :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'Isian :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'Isian :attribute field prohibits :other from being present.',
    'regex' => 'Isian :attribute format is invalid.',
    'required' => 'Isian :attribute harus diisi.',
    'required_array_keys' => 'Isian :attribute harus memuat: :values.',
    'required_if' => 'Isian :attribute field is diperlukan when :other is :value.',
    'required_unless' => 'Isian :attribute field is diperlukan unless :other is in :values.',
    'required_with' => 'Isian :attribute field is diperlukan when :values is present.',
    'required_with_all' => 'Isian :attribute field is diperlukan when :values are present.',
    'required_without' => 'Isian :attribute field is diperlukan when :values is not present.',
    'required_without_all' => 'Isian :attribute field is diperlukan when none of :values are present.',
    'same' => 'Isian :attribute and :other harus match.',
    'size' => [
        'array' => 'Isian :attribute harus contain :size items.',
        'file' => 'Isian :attribute harus be :size kilobytes.',
        'numeric' => 'Isian :attribute harus be :size.',
        'string' => ':attribute harus :size karakter.',
    ],
    'starts_with' => 'Isian :attribute harus start with one of the following: :values.',
    'string' => 'Isian :attribute harus be a string.',
    'timezone' => 'Isian :attribute harus be a valid timezone.',
    'unique' => 'Nilai :attribute telah digunakan.',
    'uploaded' => 'Isian :attribute failed to upload.',
    'url' => 'Isian :attribute harus be a valid URL.',
    'uuid' => 'Isian :attribute harus be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
