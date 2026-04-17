@echo off
chcp 65001 >nul
set "PROJECT_DIR=%~dp0"
set "OSPANEL_ROOT=%PROJECT_DIR%..\..\.."
set "PHP_EXE="

for %%V in (8.4 8.3 8.2 8.1 8.0 7.4) do (
    if exist "%OSPANEL_ROOT%\modules\php\PHP-%%V\php.exe" (set "PHP_EXE=%OSPANEL_ROOT%\modules\php\PHP-%%V\php.exe" & goto :found)
)
for %%V in (8.4 8.3 8.2 8.1 8.0 7.4) do (
    if exist "%OSPANEL_ROOT%\modules\php\PHP_%%V\php.exe" (set "PHP_EXE=%OSPANEL_ROOT%\modules\php\PHP_%%V\php.exe" & goto :found)
)
for /d %%D in ("%OSPANEL_ROOT%\modules\php\PHP-*") do (
    if exist "%%D\php.exe" (set "PHP_EXE=%%D\php.exe" & goto :found)
)
for /d %%D in ("%OSPANEL_ROOT%\modules\php\PHP_*") do (
    if exist "%%D\php.exe" (set "PHP_EXE=%%D\php.exe" & goto :found)
)

echo PHP not found. Check: %OSPANEL_ROOT%\modules\php\
pause
exit /b 1

:found
cd /d "%PROJECT_DIR%"
echo Running migrations...
"%PHP_EXE%" artisan migrate --force
if errorlevel 1 (echo Migrate failed. & pause & exit /b 1)
echo.
echo Running seeders...
"%PHP_EXE%" artisan db:seed --force
echo.
echo Done.
pause
