Currency of National Bank Ukraine
========================
Simple XML project, how parse XML NBU and render result.

Project use Symfony 2.8.

Commands
--------------
Update database with command: 
`php app/console app:load-currencies`
CRON task `* 7 * * * /usr/bin/php /[path-to-project]/app/console app:load-сurrencies`