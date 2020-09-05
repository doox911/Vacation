## Install
* Скопируте файл `.env-example` с именем `.env` и укажите базу данных (`DB_DATABASE`) и доступы к ней (`DB_USERNAME, DB_PASSWORD`); 
* Установите пакеты для PHP: `composer install`;
* Установите пакеты для JavaScript: `npm install`;
* Выполните миграции: `php artisan migrate`;
* Наполните данными: `php artisan db:seed`;
* Сгенерируйте ключ приложения: `php artisan key:generate`;
* Соберите фронт: `npm run prod`;

