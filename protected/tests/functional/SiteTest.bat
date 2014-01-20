cd /d d:\htdocs\rapid\protected\tests\
echo =============================  >> d:\htdocs\rapid\protected\tests\functional\SiteTest-log.txt
date /t >> d:\htdocs\rapid\protected\tests\functional\SiteTest-log.txt
time /t >> d:\htdocs\rapid\protected\tests\functional\SiteTest-log.txt
echo functional/SiteTest.php >> d:\htdocs\rapid\protected\tests\functional\SiteTest-log.txt
phpunit functional/SiteTest.php >> d:\htdocs\rapid\protected\tests\functional\SiteTest-log.txt
