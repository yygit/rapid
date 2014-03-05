cd /d d:\htdocs\rapid\protected\
echo =============================  >> d:\htdocs\rapid\protected\commands\JobProcessorCommand-log.txt
date /t >> d:\htdocs\rapid\protected\commands\JobProcessorCommand-log.txt
time /t >> d:\htdocs\rapid\protected\commands\JobProcessorCommand-log.txt
echo commands/JobProcessorCommand.php >> d:\htdocs\rapid\protected\commands\JobProcessorCommand-log.txt
yiic jobprocessor >> d:\htdocs\rapid\protected\commands\JobProcessorCommand-log.txt
