# 🚀 Инструкция по развертыванию Laravel на Beget

## 📌 Шаг 1: Регистрация на Beget

1. Перейдите на [beget.com](https://beget.com)
2. Нажмите "Зарегистрироваться" или "Начать"
3. Выберите **бесплатный тариф** (лучше Free/Lite)
4. Укажите домен (например `yoursite.beget.tech` для бесплатного)
5. Подтвердите почту

## 📌 Шаг 2: Получение доступа FTP

1. Войдите в **Cpanel** (ссылка в письме от Beget)
2. Найдите **FTP Accounts** (Учетные записи FTP)
3. Создайте новую FTP аккаунт:
   - **FTP User:** `your_ftp_login`
   - **Password:** `strong_password`
   - **Home Directory:** `/public_html/` (оставить по умолчанию)
4. Запомните **хост:** `ftp.yoursite.beget.tech` (или как указано)

## 📌 Шаг 3: Подготовка .env файла

Отредактируйте файл `.env` в корне проекта:

```env
APP_NAME=LaravelApp
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yoursite.beget.tech

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=yoursite_db
DB_USERNAME=yoursite_user
DB_PASSWORD=your_db_password

# Сгенерируйте новый ключ для production
APP_KEY=base64:XXXXXXXXXX
```

Чтобы сгенерировать APP_KEY локально:
```bash
php artisan key:generate
```

## 📌 Шаг 4: Создание базы данных на Beget

1. В Cpanel найдите **MySQL Databases** (Базы данных MySQL)
2. Создайте новую БД:
   - **Database Name:** `yoursite_db`
   - **Username:** `yoursite_user`
   - **Password:** `your_db_password`
3. Создайте пользователя и назначьте все привилегии

## 📌 Шаг 5: Загрузка файлов на хостинг

### Используя FileZilla (рекомендуется):

1. Скачайте [FileZilla](https://filezilla-project.org/)
2. Откройте **File → Site Manager**
3. Нажмите "New Site", заполните:
   - **Host:** `ftp.yoursite.beget.tech`
   - **Port:** `21`
   - **User:** `your_ftp_login`
   - **Password:** `your_password`
4. Нажмите "Connect"
5. Слева откройте папку проекта `C:\OSPanel\domains\localhost\laravelka`
6. **Исключите эти папки/файлы** (они не нужны на хостинге):
   - `.git`, `.idea`, `.venv`
   - `node_modules` (если есть)
   - `.env.example`, `.gitignore`
7. Загрузите **содержимое** из `public/` на хостинг в корень (обычно `/public_html/`)
8. Загрузите остальные файлы проекта в отдельную папку выше (например `../app/`)

**Правильная структура на хостинге:**
```
/public_html/
  ├── index.php (главный)
  ├── .htaccess
  ├── robots.txt
  └── ... (остальное из public/)

/../app/
  ├── storage/
  ├── config/
  ├── routes/
  ├── .env (с правильными данными)
  └── ... (остальное из проекта)
```

## 📌 Шаг 6: Настройка .htaccess

Создайте файл `/public/.htaccess`:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## 📌 Шаг 7: Загрузка базы данных

### Вариант 1: Через миграции (рекомендуется)

1. Подключитесь по SSH (если доступно) или через Terminal в Cpanel
2. Выполните:
```bash
cd /path/to/your/app
php artisan migrate --force
php artisan db:seed --force (если нужно)
```

### Вариант 2: Загрузка SQL дампа

1. Локально экспортируйте БД:
```bash
mysqldump -u root laravel > database_backup.sql
```

2. В Cpanel найдите **PhpMyAdmin**
3. Выберите вашу БД и импортируйте `database_backup.sql`

## 📌 Шаг 8: Установка зависимостей

Если Beget поддерживает SSH:
```bash
ssh yoursite@ssh.beget.tech
cd /path/to/your/app
composer install --no-dev --optimize-autoloader
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📌 Шаг 9: Финальная настройка прав доступа

По SSH или через FTP:
```bash
# Давайте права на запись
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

## 📌 Шаг 10: Проверка

1. Откройте в браузере: `https://yoursite.beget.tech`
2. Должна открыться ваша приложение
3. Проверьте логи в `storage/logs/`

---

## ⚠️ Частые ошибки на Beget

### "Class not found" / 500 Internal Server Error
```bash
php artisan cache:clear
php artisan config:clear
```

### Нет доступа к файлам
```bash
chmod -R 755 storage/
chmod 644 storage/.gitignore
```

### БД не подключается
- Проверьте `.env` - хост обычно `localhost`
- DB должна быть создана в Cpanel
- Пароль правильный

---

## 🔐 Безопасность

Обязательно:
1. ✅ Установите `APP_DEBUG=false` в .env
2. ✅ Сгенерируйте новый APP_KEY
3. ✅ Удалите `.env.example` с хостинга
4. ✅ Используйте HTTPS (автоматически на Beget)
5. ✅ Установите правильные права на файлы

---

## 📞 Если что-то не работает

1. Проверьте логи: `/storage/logs/laravel.log`
2. Посмотрите PHP версию в Cpanel (должна быть 8.0+)
3. Убедитесь что mod_rewrite включен
4. Проверьте подключение к БД

Удачи! 🚀
