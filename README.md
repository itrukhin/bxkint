# Вывод отладочной информации для администратора 1С-Битрикс ([Kint](https://github.com/kint-php/kint))

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/itrukhin/bxkint/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/itrukhin/bxkint/?branch=master)
[![Build Status](https://scrutinizer-ci.com/g/itrukhin/bxkint/badges/build.png?b=master)](https://scrutinizer-ci.com/g/itrukhin/bxkint/build-status/master)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/itrukhin/bxkint/badges/code-intelligence.svg?b=master)](https://scrutinizer-ci.com/code-intelligence)

В сложных информационных системах зачастую необходима одна и та же отладочная информация для анализа и 
поиска ошибок.
Причем эта информация нужна на продакшене, с актуальной базы. Чтобы она всегда была под рукой - 
сделал небольшую библиотеку, в основе которой лежит
популярный и удобный отладчик [Kint](https://github.com/kint-php/kint). 
Установив это расширение вы получаете как возможность стандартного использования отладчика Kint так и 
возможность добавлять в код вывод информации, видимой только для администратора и пользователей панели управления.

## Установка
```bash
composer require itrukhin/bxkint:dev-master
```

## Принцип работы
Расширение работает через обработчики событий 1С-Битрикс. Чтобы включить вывод отладочной информации, 
на административную панель добавлена кнопка-триггер,
включающая и выключающая отладку.  
![Кнопка на панели](https://raw.githubusercontent.com/itrukhin/bxkint/master/resources/button-demo.png)
Кнопка доступна на панели Битрикс, по умолчанию выключена. Состояние кнопки хранится в сессии.

В файл init.php добавляем инициализацию расширения 
(_предполагается, что у вас Битрикс уже умеет работать с автозагрузкой composer_)
```php
\App\BxKint::init();
```
В необходимых участках кода вызывается метод добавления отладочной информации:
```php
\App\BxKint::info(['name' => $value]);
```
Я, обычно, добавляю информацию как массив - тогда в отладчике автоматически появляется название 'name'. 
Но можно передавать и просто переменную.

Количество вызовов добавления информации в коде не ограничено. Все переменные собираются в один 
глобавльный массив $BX_KINT_INFO, который и выводится на эпилоге. 

Включив отладку вы увидите стандартный вывод типа:
![Пример отладки](https://raw.githubusercontent.com/itrukhin/bxkint/master/resources/debug-demo.png)
