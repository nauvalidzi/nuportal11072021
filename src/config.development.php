<?php

/**
 * PHPMaker 2021 configuration file (Development)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "ls-b9e992bc52faba574fd15397e7880de17f555d47.cpe3c4hmmuxu.us-east-2.rds.amazonaws.com", "port" => "3306", "user" => "root", "password" => "Jombang74", "dbname" => "nuportal_juli21"]
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
        "SECRET_KEY" => "lOOH7EKxg85BwNxC", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
