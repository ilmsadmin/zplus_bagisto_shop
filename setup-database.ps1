#!/usr/bin/env pwsh

# Database Setup Script for Bagisto E-commerce System

Write-Host "=== Database Setup for Bagisto E-commerce ===" -ForegroundColor Green
Write-Host ""

$currentDir = Get-Location
$backendPath = Join-Path $currentDir "backend-bagisto"

# Check if backend directory exists
if (!(Test-Path $backendPath)) {
    Write-Host "Backend directory not found!" -ForegroundColor Red
    exit 1
}

Push-Location $backendPath

# Check if .env exists
if (!(Test-Path ".env")) {
    Write-Host "Creating .env file..." -ForegroundColor Yellow
    Copy-Item ".env.example" ".env"
    Write-Host "Please edit .env file to configure your database settings" -ForegroundColor Cyan
    Write-Host "Press any key to continue after editing .env file..."
    $null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
}

Write-Host "Setting up database..." -ForegroundColor Cyan

try {
    # Generate application key
    Write-Host "Generating application key..." -ForegroundColor Yellow
    php artisan key:generate
    
    # Install composer dependencies if not already installed
    if (!(Test-Path "vendor")) {
        Write-Host "Installing composer dependencies..." -ForegroundColor Yellow
        composer install
    }
    
    # Install npm dependencies if not already installed
    if (!(Test-Path "node_modules")) {
        Write-Host "Installing npm dependencies..." -ForegroundColor Yellow
        npm install
    }
    
    # Run database migrations
    Write-Host "Running database migrations..." -ForegroundColor Yellow
    php artisan migrate
    
    # Seed database with sample data
    Write-Host "Seeding database with sample data..." -ForegroundColor Yellow
    php artisan db:seed
    
    # Create storage link
    Write-Host "Creating storage link..." -ForegroundColor Yellow
    php artisan storage:link
    
    # Clear and cache config
    Write-Host "Clearing and caching configuration..." -ForegroundColor Yellow
    php artisan config:clear
    php artisan cache:clear
    php artisan route:clear
    php artisan view:clear
    
    Write-Host ""
    Write-Host "=== Database Setup Complete! ===" -ForegroundColor Green
    Write-Host ""
    Write-Host "Default Admin Credentials:" -ForegroundColor Cyan
    Write-Host "Email: admin@example.com" -ForegroundColor White
    Write-Host "Password: admin123" -ForegroundColor White
    Write-Host ""
    Write-Host "You can now start the application using:" -ForegroundColor Yellow
    Write-Host "php artisan serve --port=8000" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Admin Panel: http://localhost:8000/admin" -ForegroundColor Green
    Write-Host "Frontend: http://localhost:8000" -ForegroundColor Green
    Write-Host "API: http://localhost:8000/api/v1" -ForegroundColor Green
}
catch {
    Write-Host "Error during setup: $($_.Exception.Message)" -ForegroundColor Red
    Write-Host "Please check your database configuration in .env file" -ForegroundColor Yellow
}

Pop-Location

Write-Host ""
Write-Host "Press any key to exit..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
