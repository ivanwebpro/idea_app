<?php


$dt = date("Y-m-d_H-i-s");

$backupname_db_sql= "db_".$dt.".sql";

$MYSQL_HOST = "localhost";
$MYSQL_USER = "idea_app";
$MYSQL_DB_NAME = "idea_app";
$MYSQL_PASSWORD = "674jtg9^u90";
$MYSQL_CHARSET = "utf8";
$MYSQL_DEBUG = false;
$MYSQL_PREFIX = '';

$webroot = "~/Web";
$backupname_path = "$webroot/db/$backupname_db_sql";

$command = "mysqldump  --opt --skip-extended-insert --lock-tables=false -h$MYSQL_HOST -u$MYSQL_USER -p$MYSQL_PASSWORD $MYSQL_DB_NAME > $backupname_path"; 

//ob_start();
print "<hr>$command<hr>";
system($command);
//ob_end_clean();

print "<b>Backup finished</b>";
