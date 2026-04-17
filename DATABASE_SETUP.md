# Инструкция по настройке базы данных

## Импорт SQL файла

### Способ 1: Через phpMyAdmin (OSPanel)

1. Откройте phpMyAdmin в браузере (обычно http://localhost/openserver/phpmyadmin/)
2. Войдите с учетными данными:
   - Пользователь: `root`
   - Пароль: (пусто)
3. Нажмите на вкладку "Импорт"
4. Нажмите "Выберите файл" и выберите файл `database.sql`
5. Нажмите кнопку "Выполнить" (Go)

### Способ 2: Через командную строку MySQL

```bash
mysql -u root -p < database.sql
```

Или если пароль пустой:
```bash
mysql -u root < database.sql
```

### Способ 3: Через Laravel миграции

Если вы предпочитаете использовать миграции Laravel:

```bash
php artisan migrate
```

## Настройки подключения

Убедитесь, что в файле `.env` указаны правильные настройки:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

## Проверка подключения

После импорта базы данных, проверьте подключение:

```bash
php artisan migrate:status
```

Или создайте тестового пользователя:

```bash
php artisan tinker
```

В консоли tinker выполните:
```php
\App\Models\User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => \Hash::make('password')
]);
```

## Структура базы данных

База данных содержит следующие таблицы:

1. **users** - Пользователи системы
2. **password_resets** - Токены для сброса паролей
3. **failed_jobs** - Неудачные задачи из очереди
4. **personal_access_tokens** - API токены для аутентификации

## Примечания

- База данных создается с кодировкой `utf8mb4` для поддержки эмодзи и специальных символов
- Все таблицы используют движок `InnoDB`
- В SQL файле закомментирован пример тестового пользователя (раскомментируйте, если нужен)
