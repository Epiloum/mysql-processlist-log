#!/usr/bin/env php
<?php
// Help Text
$help = "MySQL Process List Monitor

Usage:
  command [options]

Options:
  -h, --host=name       Connect to mysql host.
  -P, --port=#          Port number for connection or 3306 for default.
  -u, --user=user       Mysql User for login.
  -p, --password=text   Password to use when connecting to server.
  -t, --until-stopped   Keeps the monitoring until stopped by the user.
";

// Print help
if (!isset($argv[1])) {
    exit($help);
}

// Error Handling
try {
    // Check exists PDO class
    if (!class_exists('PDO')) {
        throw new Exception("Can't find the PDO class");
    }

    // Init
    $target = null;
    $host = '';
    $port = 3306;
    $user = '';
    $password = '';
    $untilStopped = false;

    // Parse arguments
    $len = count($argv);

    for ($i = 1; $i < $len; $i++) {
        if (!is_null($target)) {
            ${$target} = $argv[$i];
            $target = null;
            continue;
        }

        switch ($argv[$i]) {
            case '-h':
                $target = 'host';
                continue 2;

            case '-P':
                $target = 'port';
                continue 2;

            case '-u':
                $target = 'user';
                continue 2;

            case '-p':
                $target = 'password';
                continue 2;

            case '-t':
            case '--until-stopped':
                $untilStopped = true;
                continue 2;
        }

        if (preg_match('/^--(host|port|user|password)=(.+)$/', $argv[$i], $matches)) {
            switch($matches[1])
            {
                case 'host':
                case 'port':
                case 'user':
                case 'password':
                    ${$matches[1]} = $matches[2];
                    continue 2;
            }
        }

        throw new Exception("unknown option '" . $argv[$i]);
    }
} catch (Exception $e) {
    exit($argv[0] . ": " . $e->getMessage() . "\n");
}