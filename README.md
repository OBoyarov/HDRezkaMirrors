# HDRezkaMirrors
Получение актуального зеркала HDRezka

Для получения актуального зеркала используется отправка письма на адрес <code>mirror@hdrezka.org</code>, далее чтение почтового ящика и запись нового зеркала в файл mirrors.txt

1. Скорректировать файл config.php:
<br>Добавить данные существующего почтового ящика.
<br>Для уведомления в телеграм бот добавить токен бота и ваш идентификатор (https://core.telegram.org/bots).

2. Создать 2 CRON-задачи, на отправку письма и на проверку входящих:
<br><code>/opt/php/7.4/bin/php -f /var/www/username/data/www/domain.tld/app.php mail_send</code> (каждый час)
<br><code>/opt/php/7.4/bin/php -f /var/www/username/data/www/domain.tld/app.php mail_check</code> (каждые 15-30 минут)

Последние 5 зеркал можно получить по ссылке: <a href="https://boyaroff.ru/tools/hdrezka/mirrors" target="_blank">https://boyaroff.ru/tools/hdrezka/mirrors</a>
