#!/usr/bin/env php
<?php
// Help Text
$help = "MySQL Query List Monitor

Usage:
  command [options]

Options:
  -h, --host=name       Connect to mysql host.
  -P, --port=#          Port number for connection or 3306 for default.
  -u, --user=name       Mysql user for login.
  -p, --password=name   Password to use when connecting to server.
  -t, --until-stopped   Keeps the monitoring until stopped by the user.
                        To stop type Control-C
  -i, --interval=#      Monitoring interval in milliseconds. (500-60000)
  -f, --format=name     Output format(tsv, csv), default is tsv. 
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

    // Initialize or set default values
    $target = null;
    $host = 'localhost';
    $port = 3306;
    $user = '';
    $password = '';
    $untilStopped = false;
    $interval = 1000;
    $format = 'tsv';

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

            case '-i':
                $target = 'interval';
                continue 2;

            case '-f':
                $target = 'format';
                continue 2;
        }

        $pattern = '/^--(host|port|user|password|interval|format)=(.+)$/';

        if (preg_match($pattern, $argv[$i], $matches)) {
            switch ($matches[1]) {
                case 'host':
                case 'port':
                case 'user':
                case 'password':
                case 'interval':
                case 'format':
                    ${$matches[1]} = $matches[2];
                    continue 2;
            }
        }

        throw new Exception("Unknown option '" . $argv[$i] . "'");
    }

    // Validate interval
    if ($untilStopped) {
        if (!is_numeric($interval)) {
            throw new Exception("Invalid interval");
        } elseif ($interval < 500) {
            throw new Exception("Too short interval");
        } elseif ($interval > 60000) {
            throw new Exception("Too long interval");
        }
    }

    $interval = $untilStopped ? intval($interval, 10) : 0;

    // Connect MySQL by PDO
    $dsn = "mysql:host=" . $host . ";port=" . $port . ";charset=utf8;";
    $db = new PDO($dsn, $user, $password);

    // Execute
    do {
        $res = $db->query("SHOW FULL PROCESSLIST", PDO::FETCH_ASSOC);

        switch ($format) {
            case 'tsv':
                $sep = "\t";
                break;

            case 'csv':
                $sep = ",";
                break;

            default:
                throw new Exception('Wrong output format');
        }

        while ($v = $res->fetch()) {
            unset($v['Id']);

            array_unshift($v, date('Y-m-d H:i:s'));

            $v = array_map(
                function ($a) use ($format) {
                    if ($format == 'csv') {
                        if (strpos($a, ",") !== false) {
                            return '"' . addslashes($a) . '"';
                        } else {
                            return $a;
                        }
                    } elseif ($format == 'tsv') {
                        return str_replace("\t", " ", $a);
                    } else {
                        throw new Exception('Wrong output format');
                    }
                },
                $v
            );

            echo implode($sep, $v), "\n";
        }

        usleep($interval * 1000);
    } while ($untilStopped);
} catch (Exception $e) {
    exit($argv[0] . ": " . $e->getMessage() . "\n");
}