@echo off
setlocal enabledelayedexpansion
chcp 65001 >nul
set "PROJECT_DIR=%~dp0"
set "OSPANEL_ROOT=%PROJECT_DIR%..\..\.."
set "PHP_EXE="

REM OSPanel: PHP-8.1 (hyphen) or PHP_8.1 (underscore)
for %%V in (8.4 8.3 8.2 8.1 8.0 7.4) do (
    if exist "%OSPANEL_ROOT%\modules\php\PHP-%%V\php.exe" (
        set "PHP_EXE=%OSPANEL_ROOT%\modules\php\PHP-%%V\php.exe"
        goto :found
    )
    if exist "%OSPANEL_ROOT%\modules\php\PHP_%%V\php.exe" (
        set "PHP_EXE=%OSPANEL_ROOT%\modules\php\PHP_%%V\php.exe"
        goto :found
    )
)
for /d %%D in ("%OSPANEL_ROOT%\modules\php\PHP-*") do (
    if exist "%%D\php.exe" (set "PHP_EXE=%%D\php.exe" & goto :found)
)
for /d %%D in ("%OSPANEL_ROOT%\modules\php\PHP_*") do (
    if exist "%%D\php.exe" (set "PHP_EXE=%%D\php.exe" & goto :found)
)

echo PHP not found in OSPanel. Check: %OSPANEL_ROOT%\modules\php\
pause
exit /b 1

:found
echo Using PHP: %PHP_EXE%
cd /d "%PROJECT_DIR%"
"%PHP_EXE%" artisan serve
pause
