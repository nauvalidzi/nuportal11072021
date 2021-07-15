<?php

namespace PHPMaker2021\nuportal;

use Slim\Views\PhpRenderer;
use Slim\Csrf\Guard;
use Psr\Container\ContainerInterface;
use Monolog\Logger;
use Monolog\Handler\RotatingFileHandler;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\DebugStack;

return [
    "cache" => function (ContainerInterface $c) {
        return new \Slim\HttpCache\CacheProvider();
    },
    "view" => function (ContainerInterface $c) {
        return new PhpRenderer("views/");
    },
    "flash" => function (ContainerInterface $c) {
        return new \Slim\Flash\Messages();
    },
    "audit" => function (ContainerInterface $c) {
        $logger = new Logger("audit"); // For audit trail
        $logger->pushHandler(new AuditTrailHandler("audit.log"));
        return $logger;
    },
    "log" => function (ContainerInterface $c) {
        global $RELATIVE_PATH;
        $logger = new Logger("log");
        $logger->pushHandler(new RotatingFileHandler($RELATIVE_PATH . "log.log"));
        return $logger;
    },
    "sqllogger" => function (ContainerInterface $c) {
        $loggers = [];
        if (Config("DEBUG")) {
            $loggers[] = $c->get("debugstack");
        }
        return (count($loggers) > 0) ? new LoggerChain($loggers) : null;
    },
    "csrf" => function (ContainerInterface $c) {
        global $ResponseFactory;
        return new Guard($ResponseFactory, Config("CSRF_PREFIX"));
    },
    "debugstack" => \DI\create(DebugStack::class),
    "debugsqllogger" => \DI\create(DebugSqlLogger::class),
    "security" => \DI\create(AdvancedSecurity::class),
    "profile" => \DI\create(UserProfile::class),
    "language" => \DI\create(Language::class),
    "timer" => \DI\create(Timer::class),
    "session" => \DI\create(HttpSession::class),

    // Tables
    "fasilitasusaha" => \DI\create(Fasilitasusaha::class),
    "kitabkuning" => \DI\create(Kitabkuning::class),
    "pendidikanumum" => \DI\create(Pendidikanumum::class),
    "pengasuhpppria" => \DI\create(Pengasuhpppria::class),
    "pengasuhppwanita" => \DI\create(Pengasuhppwanita::class),
    "pesantren" => \DI\create(Pesantren::class),
    "santrikitabkuning" => \DI\create(Santrikitabkuning::class),
    "user" => \DI\create(User::class),
    "userlevelpermissions" => \DI\create(Userlevelpermissions::class),
    "userlevels" => \DI\create(Userlevels::class),
    "fasilitaspesantren" => \DI\create(Fasilitaspesantren::class),
    "berita" => \DI\create(Berita::class),
    "kabupatens" => \DI\create(Kabupatens::class),
    "kecamatans" => \DI\create(Kecamatans::class),
    "kelurahans" => \DI\create(Kelurahans::class),
    "provinsis" => \DI\create(Provinsis::class),
    "jenispendidikanumum" => \DI\create(Jenispendidikanumum::class),
    "wilayah" => \DI\create(Wilayah::class),
    "jenispendidikanpesantren" => \DI\create(Jenispendidikanpesantren::class),
    "pendidikanpesantren" => \DI\create(Pendidikanpesantren::class),

    // User table
    "usertable" => \DI\get("user"),
];
