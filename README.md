# Вывод отладочной информации для администратора 1С-Битрикс ([Kint](https://github.com/kint-php/kint))

В сложных информационных системах зачастую необходима одна и та же отладочная информация для анализа и поиска ошибок.
Причем эта информация нужна на продакшене, с актуальной базы. Чтобы она всегда была под рукой - сделал небольшую библиотеку, в основе которой лежит
популярная и удобная библиотека [Kint](https://github.com/kint-php/kint). Установив это расширение вы получаете возможность стандартного использования 
отладчика Kint плюс возможность добавлять в код вывод информации, видимой только для администратора.

# Принцип работы
Расширение работает через обработчики событий 1С-Битрикс. Чтобы включить вывод отладдочной информации, на административную панель добавлена кнопка-триггер,
включающая и выключающая отладку.  
![Кнопка на панели](https://raw.githubusercontent.com/itrukhin/bxkint/master/resources/button-demo.png)
Кнопка доступна только администратору, по умолчанию выключена. Состояние кнопки хранится в сессии.

В необходимых участках кода вызывается метод добавления отладочной информации:
```php
\App\BxKint::info(['name' => $value]);
```
Я, обычно, добавляю информацию как массив - тогда в отладчике автоматически появляется название 'name'

Количество вызовов добавления информации в коде не ограничено. Все переменные собираются в один глобавльный массив $BX_KINT_INFO, который и выводится на эпилоге. 

Включив отладку вы увидите стандартный вывод типа:
![Пример отладки](https://raw.githubusercontent.com/itrukhin/bxkint/master/resources/debug-demo.png)
