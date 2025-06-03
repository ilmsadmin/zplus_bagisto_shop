#!/usr/bin/env pwsh

# Start All Services Script for E-commerce System
# Bagisto Backend + Next.js Frontend + Flutter Mobile App

Write-Host "=== E-commerce System Startup Script ===" -ForegroundColor Green
Write-Host ""

# Function to check if port is available
function Test-Port {
    param([int]$Port)
    try {
        $connection = New-Object System.Net.Sockets.TcpClient
        $connection.Connect("localhost", $Port)
        $connection.Close()
        return $true
    }
    catch {
        return $false
    }
}

# Function to start service in background
function Start-ServiceAsync {
    param(
        [string]$Name,
        [string]$Path,
        [string]$Command,
        [int]$Port
    )
    
    Write-Host "Starting $Name..." -ForegroundColor Yellow
    
    if (Test-Port -Port $Port) {
        Write-Host "Port $Port is already in use. Skipping $Name" -ForegroundColor Red
        return
    }
    
    Push-Location $Path
    Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$Path'; $Command" -WindowStyle Normal
    Pop-Location
    
    Write-Host "$Name started on port $Port" -ForegroundColor Green
}

# Check prerequisites
Write-Host "Checking prerequisites..." -ForegroundColor Cyan

# Check PHP
try {
    $phpVersion = php --version | Select-String "PHP (\d+\.\d+)" | ForEach-Object { $_.Matches[0].Groups[1].Value }
    Write-Host "✓ PHP $phpVersion found" -ForegroundColor Green
}
catch {
    Write-Host "✗ PHP not found. Please install PHP 8.1+" -ForegroundColor Red
    exit 1
}

# Check Composer
try {
    composer --version | Out-Null
    Write-Host "✓ Composer found" -ForegroundColor Green
}
catch {
    Write-Host "✗ Composer not found. Please install Composer" -ForegroundColor Red
    exit 1
}

# Check Node.js
try {
    $nodeVersion = node --version
    Write-Host "✓ Node.js $nodeVersion found" -ForegroundColor Green
}
catch {
    Write-Host "✗ Node.js not found. Please install Node.js 18+" -ForegroundColor Red
    exit 1
}

# Check Flutter (optional)
try {
    $flutterVersion = flutter --version | Select-String "Flutter (\d+\.\d+\.\d+)" | ForEach-Object { $_.Matches[0].Groups[1].Value }
    Write-Host "✓ Flutter $flutterVersion found" -ForegroundColor Green
    $flutterAvailable = $true
}
catch {
    Write-Host "⚠ Flutter not found. Mobile app won't be started" -ForegroundColor Yellow
    $flutterAvailable = $false
}

Write-Host ""

# Start services
$currentDir = Get-Location

# 1. Start Bagisto Backend
Write-Host "=== Starting Bagisto Backend ===" -ForegroundColor Cyan
$backendPath = Join-Path $currentDir "backend-bagisto"

if (Test-Path $backendPath) {
    # Check if .env exists
    if (!(Test-Path (Join-Path $backendPath ".env"))) {
        Write-Host "Creating .env file for backend..." -ForegroundColor Yellow
        Push-Location $backendPath
        Copy-Item ".env.example" ".env"
        Pop-Location
    }
    
    # Check if vendor exists
    if (!(Test-Path (Join-Path $backendPath "vendor"))) {
        Write-Host "Installing backend dependencies..." -ForegroundColor Yellow
        Push-Location $backendPath
        composer install
        Pop-Location
    }
    
    Start-ServiceAsync -Name "Bagisto Backend" -Path $backendPath -Command "php artisan serve --port=8000" -Port 8000
    Start-Sleep 2
} else {
    Write-Host "Backend directory not found!" -ForegroundColor Red
}

# 2. Start Next.js Frontend
Write-Host ""
Write-Host "=== Starting Next.js Frontend ===" -ForegroundColor Cyan
$frontendPath = Join-Path $currentDir "frontend-nextjs"

if (Test-Path $frontendPath) {
    # Check if .env.local exists
    if (!(Test-Path (Join-Path $frontendPath ".env.local"))) {
        Write-Host "Creating .env.local file for frontend..." -ForegroundColor Yellow
        Push-Location $frontendPath
        Copy-Item ".env.example" ".env.local"
        Pop-Location
    }
    
    # Check if node_modules exists
    if (!(Test-Path (Join-Path $frontendPath "node_modules"))) {
        Write-Host "Installing frontend dependencies..." -ForegroundColor Yellow
        Push-Location $frontendPath
        npm install --omit=optional
        Pop-Location
    }
    
    Start-ServiceAsync -Name "Next.js Frontend" -Path $frontendPath -Command "npm run dev" -Port 3000
    Start-Sleep 2
} else {
    Write-Host "Frontend directory not found!" -ForegroundColor Red
}

# 3. Start Flutter Mobile App (optional)
if ($flutterAvailable) {
    Write-Host ""
    Write-Host "=== Starting Flutter Mobile App ===" -ForegroundColor Cyan
    $mobilePath = Join-Path $currentDir "mobile-app"
    
    if (Test-Path $mobilePath) {
        Write-Host "Flutter mobile app directory found." -ForegroundColor Green
        Write-Host "To run the mobile app, open a new terminal and run:" -ForegroundColor Yellow
        Write-Host "cd mobile-app && flutter run" -ForegroundColor Cyan
    } else {
        Write-Host "Mobile app directory not found!" -ForegroundColor Red
    }
}

Write-Host ""
Write-Host "=== Services Status ===" -ForegroundColor Green
Write-Host "Backend (Bagisto):  http://localhost:8000" -ForegroundColor White
Write-Host "Admin Panel:        http://localhost:8000/admin" -ForegroundColor White
Write-Host "Frontend (Next.js): http://localhost:3000" -ForegroundColor White
Write-Host "API Endpoint:       http://localhost:8000/api/v1" -ForegroundColor White
Write-Host ""
Write-Host "Press any key to open the applications in browser..." -ForegroundColor Yellow
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")

# Open browsers
Start-Process "http://localhost:8000"
Start-Process "http://localhost:3000"

Write-Host ""
Write-Host "All services started successfully!" -ForegroundColor Green
Write-Host "Check the individual terminal windows for logs and errors." -ForegroundColor Cyan
Write-Host ""
Write-Host "To stop all services, close the terminal windows or press Ctrl+C in each." -ForegroundColor Yellow
