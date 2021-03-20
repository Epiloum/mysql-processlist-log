# My Process Monitor

The My Process Monitor is a command-line tool that displays a list of process on MySQL(or MariaDB). It can be used to observe count of processes or find slow queries.

It is available on any OS installed PHP. You can execute it by php:
    
    php myprocessmonitor [options]

If you execute it without any options, you will get the following usage guidelines.

    [#] php myprocessmonitor.php
    MySQL Query List Monitor

    Usage:
        command [options]

    Options:                                                                                                                  
        -h, --host=name       Connect to mysql host.
        -P, --port=#          Port number for connection or 3306 for default.
        -u, --user=name       Mysql user for login.
        -p, --password=name   Password to use when connecting to server.
        -t, --until-stopped   Keeps the monitoring until stopped by the user.
                              To stop type Control-C
        -i, --interval=#      Monitoring interval in milliseconds. (500-60000)                                                  -f, --format=name     Output format(tsv, csv), default is tsv.
