# Run Laravel dev server using OSPanel PHP (when php is not in PATH)
$ProjectDir = $PSScriptRoot
$OSPanelRoot = (Resolve-Path (Join-Path $ProjectDir "..\..\..") -ErrorAction SilentlyContinue).Path

if (-not $OSPanelRoot) {
    Write-Host "OSPanel root not found. Project should be in OSPanel\domains\localhost\..." -ForegroundColor Red
    exit 1
}

$phpDir = Join-Path $OSPanelRoot "modules\php"
$phpExe = $null

# If you have PHP elsewhere, set env: PHP_EXE = "C:\path\to\php.exe"
if ($env:PHP_EXE -and (Test-Path $env:PHP_EXE)) {
    $phpExe = $env:PHP_EXE
}

if (-not $phpExe) {
    if (-not (Test-Path $phpDir)) {
        Write-Host "Folder does not exist: $phpDir" -ForegroundColor Red
        Write-Host "Install PHP via OSPanel: open OSPanel -> Settings -> Modules -> PHP -> download/select version." -ForegroundColor Yellow
        exit 1
    }
    # OSPanel: PHP-8.1 (hyphen) or PHP_8.1 (underscore)
    $versions = @("8.4", "8.3", "8.2", "8.1", "8.0", "7.4")
    foreach ($v in $versions) {
        foreach ($prefix in @("PHP-$v", "PHP_$v")) {
            $path = Join-Path $phpDir "$prefix\php.exe"
            if (Test-Path $path) { $phpExe = $path; break }
        }
        if ($phpExe) { break }
    }
    if (-not $phpExe) {
        Get-ChildItem -Path $phpDir -Directory -ErrorAction SilentlyContinue | Where-Object { $_.Name -match '^PHP[-_]' } | ForEach-Object {
            $exe = Join-Path $_.FullName "php.exe"
            if (Test-Path $exe) { $phpExe = $exe; break }
        }
    }
}

if (-not $phpExe) {
    Write-Host "PHP not found in: $phpDir" -ForegroundColor Red
    $subdirs = Get-ChildItem -Path $phpDir -Directory -ErrorAction SilentlyContinue
    if ($subdirs) {
        Write-Host "Found folders: $($subdirs.Name -join ', ')" -ForegroundColor Gray
    } else {
        Write-Host "Folder is empty. Install PHP via OSPanel." -ForegroundColor Gray
    }
    Write-Host ""
    Write-Host "What to do:" -ForegroundColor Yellow
    Write-Host "  1. Open OSPanel -> right-click tray icon -> Settings -> Modules -> PHP."
    Write-Host "  2. Download/select a PHP version (e.g. 8.1 or 8.2) and apply."
    Write-Host "  3. Or set PHP path: `$env:PHP_EXE = 'C:\path\to\php.exe'"
    exit 1
}

Write-Host "Using PHP: $phpExe" -ForegroundColor Green
Set-Location $ProjectDir
& $phpExe artisan serve
