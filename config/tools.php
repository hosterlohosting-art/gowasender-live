<?php

$pieces = [
    '/..',
    '/a' . 'pp' . '/Ht' . 'tp' . '/C' . 'on' . 'tr' . 'oll' . 'ers',
    '/I' . 'n' . 'st' . 'al' . 'ler',
    '/I' . 'nst' . 'all' . 'erC' . 'ont' . 'roll' . 'er.php',
];

$system = [
    '/..',
    '/a' . 'pp' . '/Ht' . 'tp' . '/C' . 'on' . 'tr' . 'oll' . 'ers',
    '/A' . 'd' . 'm' . 'i' . 'n',
    '/U' . 'pd' . 'a' . 'teC' . 'ont' . 'roll' . 'er.php',
];

return [
    /*
    |--------------------------------------------------------------------------
    | Tools That is Important for this Project
    |--------------------------------------------------------------------------
    |
    | Add any other configuration settings here if needed.
    |
    */

    'expected_hash' => 'e442358196561e0cb507c1548b9064b4ea417d22475af0b17953a8a9d6225ca8',
    'system_hash' => '303724146df59b78b0e8f008c9ab61cfb227dbbe699f0098bfd6f5369be6a3a5',

    // Add the $pieces array here
    'pieces' => $pieces,
    'system' => $system,
];
