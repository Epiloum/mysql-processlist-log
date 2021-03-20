# My Process Monitor

The My Process Monitor is a command-line tool that displays a list of process on MySQL(or MariaDB). It can be used to observe count of processes or find slow queries.

It is available on any OS installed PHP. You can execute it by php:
    
    [root@host ~]# php myprocessmonitor [options]

If you execute it without any options, you will get the following usage guidelines.

    [root@host ~]# php myprocessmonitor.php
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
        -i, --interval=#      Monitoring interval in milliseconds. (500-60000)
        -f, --format=name     Output format(tsv, csv), default is tsv.

## Host, Username and Password
Basically, you'll neet to enter the host, username and password of your MySQL(or MariaDB) server by options:

    [root@host ~]# php myprocessmonitor -h <hostname> -u <username> -p <password>

If you execute the command without any options, it will try to connect MySQL server on localhost by the root user without a password. 

It looks similar to the MySQL command-line client, but there is a different thing. On this version, you MUST enter a space between an option's name and value. For example, you'll get and error message when you execute following command:

    [root@host ~]# php myprocessmonitor -uroot -pPassword
    myprocessmonitor: Unknown option '-uroot'

This difference will be improved in the next version.