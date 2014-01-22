cd /d d:\htdocs\rapid\protected\
echo =============================  >> d:\htdocs\rapid\protected\commands\RbacCommand-log.txt
date /t >> d:\htdocs\rapid\protected\commands\RbacCommand-log.txt
time /t >> d:\htdocs\rapid\protected\commands\RbacCommand-log.txt
echo commands/RbacCommand.php >> d:\htdocs\rapid\protected\commands\RbacCommand-log.txt
yiic rbac >> d:\htdocs\rapid\protected\commands\RbacCommand-log.txt
