cd /d d:\htdocs\rapid\protected\tests\
echo =============================  >> d:\htdocs\rapid\protected\tests\unit\TypeGradeTest-log.txt
date /t >> d:\htdocs\rapid\protected\tests\unit\TypeGradeTest-log.txt
time /t >> d:\htdocs\rapid\protected\tests\unit\TypeGradeTest-log.txt
echo unit/TypeGradeTest.php >> d:\htdocs\rapid\protected\tests\unit\TypeGradeTest-log.txt
phpunit unit/TypeGradeTest.php >> d:\htdocs\rapid\protected\tests\unit\TypeGradeTest-log.txt
