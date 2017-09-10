<?php
return [
    'driver' =>'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'from' => [
        'address' => 'siyoznet@gmail.com',
        'name' => 'siyoznet'
    ],
    'encryption' => 'tls',
    'username' => 'siyoznet@gmail.com',
    'password' => 'enugnjluztfvcpae',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
];
