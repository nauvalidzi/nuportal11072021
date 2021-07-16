<?php

/**
 * PHPMaker 2021 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "ls-faa4a2656edc82c3f2ac28f451e2d48ca317d20a.cpe3c4hmmuxu.us-east-2.rds.amazonaws.com", "port" => "3306", "user" => "dbmasteruser", "password" => "Jombang74", "dbname" => "nuportal"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "smtp.gmail.com", // SMTP server
        "SERVER_PORT" => 587, // SMTP server port
        "SECURE_OPTION" => "tls",
        "SERVER_USERNAME" => "portalnu2021@gmail.com", // SMTP server user name
        "SERVER_PASSWORD" => "NUadmin2021", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "rkafMPf177PayuKh", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
