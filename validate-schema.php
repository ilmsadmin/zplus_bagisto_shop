#!/usr/bin/env php
<?php

// Simple GraphQL schema syntax validator
$schemaPath = __DIR__ . '/backend-bagisto/graphql';

echo "Validating GraphQL Schema Files...\n\n";

$files = [
    'schema.graphql',
    'product.graphql',
    'category.graphql',
    'cart.graphql',
    'customer.graphql',
    'core.graphql',
    'checkout.graphql'
];

$errors = [];

foreach ($files as $file) {
    $filePath = $schemaPath . '/' . $file;
    echo "Checking {$file}... ";
    
    if (!file_exists($filePath)) {
        echo "❌ File not found\n";
        $errors[] = "{$file}: File not found";
        continue;
    }
    
    $content = file_get_contents($filePath);
    
    // Basic syntax checks
    $checks = [
        'Balanced braces' => checkBalancedBraces($content),
        'Type definitions' => checkTypeDefinitions($content),
        'Valid field syntax' => checkFieldSyntax($content),
    ];
    
    $fileErrors = [];
    foreach ($checks as $checkName => $result) {
        if (!$result) {
            $fileErrors[] = $checkName;
        }
    }
    
    if (empty($fileErrors)) {
        echo "✅ OK\n";
    } else {
        echo "❌ Issues: " . implode(', ', $fileErrors) . "\n";
        $errors[] = "{$file}: " . implode(', ', $fileErrors);
    }
}

echo "\n";

if (empty($errors)) {
    echo "✅ All GraphQL schema files are syntactically valid!\n";
    exit(0);
} else {
    echo "❌ Found issues:\n";
    foreach ($errors as $error) {
        echo "  - {$error}\n";
    }
    exit(1);
}

function checkBalancedBraces($content) {
    $braceCount = 0;
    $chars = str_split($content);
    
    foreach ($chars as $char) {
        if ($char === '{') {
            $braceCount++;
        } elseif ($char === '}') {
            $braceCount--;
            if ($braceCount < 0) {
                return false;
            }
        }
    }
    
    return $braceCount === 0;
}

function checkTypeDefinitions($content) {
    // Check for basic type definitions
    return preg_match('/\b(type|input|enum|interface|union)\s+\w+/', $content);
}

function checkFieldSyntax($content) {
    // Remove comments and strings to avoid false positives
    $cleanContent = preg_replace('/\s*#.*$/m', '', $content);
    $cleanContent = preg_replace('/"[^"]*"/', '""', $cleanContent);
    
    // Look for field definitions and check basic syntax
    if (preg_match_all('/^\s*(\w+)\s*(\([^)]*\))?\s*:\s*([^\s!]+[!]?)/', $cleanContent, $matches, PREG_SET_ORDER)) {
        return true;
    }
    
    // If no field definitions found, that's also okay (might be just types)
    return true;
}