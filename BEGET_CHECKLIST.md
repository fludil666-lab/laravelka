# 📋 CHECKLISTS: Подготовка к загрузке на Beget

## ✅ ЧТО УЖЕ ГОТОВО:

- ✅ `.env.beget` - готовый конфиг для Beget (заполните YOUR_DATA)
- ✅ `database_dump.sql` - дамп вашей БД (~40KB)
- ✅ Все исходники приложения

---

## 🔧 ШАГ 1: РЕГИСТРАЦИЯ НА BEGET

1. Перейдите на https://beget.com
2. Выберите **БЕСПЛАТНЫЙ** план
3. Создайте аккаунт с почтой
4. **Запомните**: ваш домен будет `yourname.beget.tech`

---

## 🔑 ШАГ 2: ПОЛУЧИТЕ FTP ДОСТУП

После регистрации:
1. Войдите в [Beget Cpanel](https://panel.beget.com)
2. Слева найдите **FTP Accounts** (Учетные записи FTP)
3. Создайте новую:
   - Login: `yourname`
   - Password: придумайте
4. Запомните: Host = `ftp.yourname.beget.tech`

---

## 🗂️ ШАГ 3: СОЗДАЙТЕ БД НА BEGET

В Cpanel:
1. Найдите **MySQL Databases** (Базы данных)
2. Создайте:
   - Database: `yourname_db`
   - User: `yourname_user`
   - Password: придумайте
3. Дайте все привилегии
4. **ЗАПОМНИТЕ эти данные!**

---

## 📝 ШАГ 4: ПОДГОТОВЬТЕ .env ФАЙЛ

На ВАШ компьютере:
1. Откройте файл `.env.beget` (в проекте)
2. Замените:
   ```
   APP_URL=https://ВАШДОМЕН.beget.tech
   DB_DATABASE=yourname_db
   DB_USERNAME=yourname_user
   DB_PASSWORD=пароль_который_вы_задали
   ```
3. Сохраните как `.env` (переименуйте)

---

## 📥 ШАГ 5: СКАЧАЙТЕ И УСТАНОВИТЕ FILEZILLA

1. Скачайте https://filezilla-project.org/download.php
2. Установите (Next, Next, Finish)
3. Откройте FileZilla

---

## 🚀 ШАГ 6: ПОДКЛЮЧЕНИЕ К FTP

В FileZilla:
1. **File → Site Manager**
2. Нажмите **New Site**
3. Заполните:
   ```
   Protocol: FTP
   Host: ftp.yourname.beget.tech
   Port: 21
   Encryption: Only use plain FTP
   Login Type: Normal
   User: yourname
   Password: your_ftp_password
   ```
4. Нажмите **Connect**

---

## 📤 ШАГ 7: ЗАГРУЗКА ФАЙЛОВ

### В левой части FileZilla (ВАШ КОМПЬЮТЕР):
```
C:\OSPanel\domains\localhost\laravelka\
```

### В правой части FileZilla (BEGET ХОСТИНГ):
Там будет папка `public_html`

### ЗАГРУЖАЙТЕ:

**A) Из папки `public/` (содержимое, не саму папку):**
- `index.php`
- `.htaccess`
- `robots.txt`
- `favicon.ico`
- ... все остальное

**Куда:** В `/public_html/` (это корень вашего сайта)

**B) Остальные папки проекта:**
- `app/`
- `bootstrap/`
- `config/`
- `database/`
- `resources/`
- `routes/`
- `storage/`
- `vendor/` (опционально если весит много)
- `.env` (ВАЖНО! с вашими данными для Beget)
- `artisan`
- `composer.json`
- `composer.lock`

**Куда:** На УРОВЕНЬ ВЫШЕ `public_html` (в корень FTP)

---

## 📊 ИТОГОВАЯ СТРУКТУРА НА BEGET:

```
/home/yourname/
├── /public_html/
│   ├── index.php (главный файл)
│   ├── .htaccess
│   ├── favicon.ico
│   ├── robots.txt
│   └── css, js, images...
│
├── app/
├── bootstrap/
├── config/
├── routes/
├── .env (с данными Beget!)
├── artisan
└── composer.json
```

---

## 🗄️ ШАГ 8: ЗАГРУЗИТЕ БД

### Вариант A (Рекомендуется):

1. В Cpanel найдите **phpMyAdmin**
2. Выберите вашу БД (`yourname_db`)
3. Вкладка **Import**
4. Выберите файл `database_dump.sql` (из проекта)
5. Нажмите **Go**

### Вариант B (Если есть SSH):

```bash
ssh yourname@ssh.beget.tech
cd /home/yourname
mysql -u yourname_user -p yourname_db < database_dump.sql
```
(Введите пароль БД)

---

## ⚙️ ШАГ 9: ФИНАЛЬНАЯ НАСТРОЙКА

Если есть доступ по SSH:

```bash
ssh yourname@ssh.beget.tech

# Перейдите в папку проекта
cd /home/yourname

# Дайте права на запись
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Безопасность
chmod 644 .env

# Очистите кэш
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🌐 ШАГ 10: ПРОВЕРКА

1. Откройте в браузере: `https://yourname.beget.tech`
2. Должна открыться ваша приложение!
3. Проверьте все функции: регистрация, вход, БД

---

## 🆘 ЕСЛИ НЕ РАБОТАЕТ:

### Ошибка 404:
- Проверьте что `index.php` в `/public_html/`
- Проверьте `.htaccess`
- Удалите `index.html` если есть

### Белый экран / 500 ошибка:
- Посмотрите логи: `storage/logs/laravel.log` (через FTP)
- Проверьте `.env` - правильные ли данные БД

### БД не подключается:
- Host = `localhost` (не 127.0.0.1)
- DB, User, Password точно как задали в Cpanel
- Проверьте что БД создана

### Не найден класс / проблемы с vendor:
```bash
ssh yourname@ssh.beget.tech
cd /home/yourname
composer install --no-dev
```

---

## 📋 ФИНАЛЬНЫЙ ЧЕКЛИСТ:

- [ ] Создан аккаунт на Beget
- [ ] Получены FTP данные
- [ ] Создана БД в Cpanel
- [ ] Готов `.env` файл для Beget
- [ ] Скачена и установлена FileZilla
- [ ] Подключены по FTP
- [ ] Загружены файлы из `public/` в `/public_html/`
- [ ] Загружены остальные файлы проекта
- [ ] Загружена БД через phpMyAdmin
- [ ] Даны права на `storage/` и `bootstrap/cache/`
- [ ] Сайт открывается на https://yourname.beget.tech

---

## 💡 ПОЛЕЗНЫЕ КОМАНДЫ BEGET SSH:

```bash
# Информация о PHP
php -v

# Список установленных расширений
php -m

# Где находится php.ini
php --ini

# Проверить подключение БД
php artisan tinker
>>> DB::connection()->getPdo()

# Посмотреть логи приложения
tail -f storage/logs/laravel.log

# Очистить кэш
php artisan cache:clear
php artisan config:clear
```

---

✅ **ВСЕ ГОТОВО! МОЖЕТЕ ЗАЛИВАТЬ!**
