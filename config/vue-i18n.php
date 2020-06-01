<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Laravel languages path
    |--------------------------------------------------------------------------
    |
    | The default path where the languages are stored by Laravel.
    | Note: the path will be prepended to point to the App directory.
    |
     */
    'root_path' => resource_path('lang'),

    /*
    |--------------------------------------------------------------------------
    | Excluded files & folders
    |--------------------------------------------------------------------------
    |
    | Exclude translation files, generic files or folders you don't need.
    |
    */
    'exclude' => [
        'validation'
    ],

    /*
    |--------------------------------------------------------------------------
    | Output file
    |--------------------------------------------------------------------------
    |
    | The javascript path where I will place the generated file.
    | Note: the path will be prepended to point to the App directory.
    |
    */
    'output_file' => resource_path('js/i18n/messages.js'),

    /*
    |--------------------------------------------------------------------------
    | Escape character
    |--------------------------------------------------------------------------
    |
    | Allows to escape translations strings that should not be treated as a
    | variable
    |
    */
    'escape_character' => '!',

    /*
    |--------------------------------------------------------------------------
    | Output messages
    |--------------------------------------------------------------------------
    |
    | Specify if the library should show "written to" messages
    | after generating json files.
    |
    */
    'output_messages' => true,
];
