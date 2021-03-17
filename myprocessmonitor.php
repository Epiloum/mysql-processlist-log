#!/usr/bin/env php
<?php
// Help Text
$help = "MySQL Process List Monitor

Usage:
  command [options]

Options:
  -h, --host=name       Connect to mysql host.
  -u, --user=user       Mysql User for login.
  -p, --password=text   Password to use when connecting to server.
  -t, --until-stopped   Keeps the monitoring until stopped by the user.
";

// Print help
if (!isset($argv[1])) {
    exit($help);
}