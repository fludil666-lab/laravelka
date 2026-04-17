# Требования к окружению

## Проект

- **Laravel** 8.x  
- **PHP** 7.3+ или 8.0+ (в `composer.json` указано: `"php": "^7.3|^8.0"`)

Рекомендуется **PHP 8.0** или **8.1** для Laravel 8.

---

## Расширения PHP (обязательны для Laravel)

| Расширение | Назначение |
|------------|------------|
| BCMath | Математика произвольной точности |
| Ctype | Проверка типов символов |
| Fileinfo | Определение типа файла |
| JSON | Работа с JSON |
| Mbstring | Многобайтовые строки |
| OpenSSL | Шифрование, HTTPS |
| PDO | Работа с БД |
| Tokenizer | Токенизатор PHP |
| XML | Работа с XML |

В OSPanel эти расширения обычно уже включены. Проверить: в папке OSPanel откройте настройки → модули → PHP → расширения (или посмотрите `php.ini`).

---

## Как запустить сервер

### 1. PowerShell (терминал Cursor)

**Сначала перейдите в папку проекта**, затем запустите скрипт:

```powershell
cd c:\OSPanel\domains\localhost\qweqwe
.\run-serve.ps1
```

Или одной строкой:

```powershell
cd c:\OSPanel\domains\localhost\qweqwe; .\run-serve.ps1
```

Если появится ошибка про политику выполнения:

```powershell
Set-ExecutionPolicy -Scope CurrentUser -ExecutionPolicy RemoteSigned
```

После этого снова запустите `.\run-serve.ps1`.

### 2. CMD или двойной щелчок

- Запустите **serve.bat** (двойной щелчок в проводнике или из cmd: `serve.bat`).

### 3. Добавить PHP в PATH (один раз)

Чтобы команда `php` работала в любом терминале:

1. Узнайте путь к PHP в OSPanel, например:  
   `C:\OSPanel\modules\php\PHP-8.2`  
   (или `PHP-8.1`, смотрите папки в `C:\OSPanel\modules\php\`).
2. Параметры Windows → «Дополнительные параметры системы» → «Переменные среды».
3. В **Path** добавьте эту папку (например `C:\OSPanel\modules\php\PHP-8.2`).
4. Перезапустите терминал, затем:  
   `php artisan serve`

---

## Если сервер не запускается

1. **PHP не найден**  
   Проверьте, что в `C:\OSPanel\modules\php\` есть папка вида `PHP-8.x` с файлом `php.exe`.

2. **Ошибка расширений**  
   В OSPanel включите нужные расширения в настройках PHP или в `php.ini` (раскомментируйте строки `extension=...` для BCMath, OpenSSL, mbstring и т.д.).

3. **Порт 8000 занят**  
   Запуск с другим портом:  
   `php artisan serve --port=8080`  
   (в run-serve.ps1 или serve.bat при необходимости замените команду на эту).
