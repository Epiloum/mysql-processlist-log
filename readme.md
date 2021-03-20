# My Process Monitor

The My Process Monitor is a command-line tool that displays a list of process on MySQL(or MariaDB). It connects to a specific MySQL server and exports result of "SHOW FULL PROCESSLIST" Statement to stdout. It can be used to observe count of processes or find slow queries.

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
Basically, you'll neet to enter the host, username and password of your MySQL server by options:

    [root@host ~]# php myprocessmonitor -h <hostname> -u <username> -p <password>

If you execute the command without any options, it will try to connect MySQL server on localhost by the root user without a password. 

It looks similar to the MySQL command-line client, but there is a different thing. On this version, you MUST enter a space between an option's name and value. For example, you'll get and error message when you execute following command:

    [root@host ~]# php myprocessmonitor -uroot -pPassword
    myprocessmonitor: Unknown option '-uroot'

This difference will be improved in the next version.

## Until-stopped option and interval
If you execute it with the until-stopped option(-t or --until-stopped), it will display a list of process until stopped by usegin Control-C. This option works the same as until-stopped option of the _ping_ command on the Linux or Windows CLI.

    [root@host ~]# php myprocessmonitor -t -u root -p Password
    2021-03-20 10:27:43     root    172.22.0.1:42708                Query   0       starting                SHOW FULL PROCESSLIST
    2021-03-20 10:27:43     root    172.22.0.1:42711    service     Sleep   4
    2021-03-20 10:27:43     usrweb  172.22.0.1:42714    service     Query   1       Copying to tmp table    SELECT * FROM users WHERE created_at >= '2021-03-20'

If you want to set the interval of displaying, you can use an interval option(-i or --interval=#) by milliseconds between 500 and 60000. It only works with the until-stopped option.

    [root@host ~]# php myprocessmonitor -t -i3000 -u root -p Password
    2021-03-20 10:27:43     root    172.22.0.1:42708                Query   0       starting                SHOW FULL PROCESSLIST
    2021-03-20 10:27:43     root    172.22.0.1:42711    service     Sleep   4
    2021-03-20 10:27:43     usrweb  172.22.0.1:42714    service     Query   1       Copying to tmp table    SELECT * FROM users WHERE created_at >= '2021-03-20'
    2021-03-20 10:27:46     root    172.22.0.1:42708                Query   0       starting                SHOW FULL PROCESSLIST
    2021-03-20 10:27:46     root    172.22.0.1:42711    service     Sleep   7
    2021-03-20 10:27:46     usrweb  172.22.0.1:42714    service     Sleep   2
