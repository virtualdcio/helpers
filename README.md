# Helpers
Сприпты на все случаи жизни :)

1. Автоочистка Slave серверов PowerDNS от доменов, даленных на Master серверах
   pdns_cleaner.php - инструкция по работе внутри файла.
   Нужные пакеты на сервере: php, php-common, php-cli, php-mysql - ставим из репозитория epel
   Натройка cron:
   0 * * * * * /usr/bin/php /root/pdns_cleaner.php
2. 
