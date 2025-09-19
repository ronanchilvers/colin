<?php

$container->set(
    /** @var array $config */
    \App\Database\Connection::class,
    function () use ($config) {
        return new \App\Database\Connection(
            $config['database']['dsn'],
            $config['database']['username'],
            $config['database']['password']
        );
    }
);
