<?php

//INCLUDES
require_once "functions.php";
require_once "mail.class.php";
require_once "telegram.class.php";

//PROJECT
define("PR_NAME", "HDRezkaMirrors"); //Имя проекта
define("PR_FLOCK_USE", true); //Использование функции flock

//MAIL
define("SMTP_DEBUG", 2); //Отладка при отправке. 0 = off, 1 = client messages, 2 = client and server messages
define("SMTP_HOST", ""); // Почтовый сервер
define("SMTP_PORT", 587); //SMTP порт. Not secure - 25 or 587, secure - 465
define("SMTP_USER", ""); //Пользователь ящика
define("SMTP_PASS", ""); //Пароль пользователя ящика
define("SMTP_FROM", ""); //От кого (почтовый ящик)
define("SMTP_TO", "mirror@hdrezka.org"); //Кому

define("IMAP_PORT", 143); //IMAP порт. Not secure - 143, secure - 993


//TG
define("TG_TOKEN", ""); //Токен telegram бота
define("TG_ADMIN", ""); //Идентификатор админа telegram бота