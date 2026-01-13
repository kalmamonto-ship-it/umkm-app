<?php
// infinityfree-config.php

/**
 * Konfigurasi khusus untuk hosting InfinityFree
 */

// Deteksi apakah aplikasi berjalan di InfinityFree
if (!defined('INFINITYFREE_HOSTING')) {
    define('INFINITYFREE_HOSTING', strpos($_SERVER['HTTP_HOST'] ?? '', 'infinityfreeapp.com') !== false);
}

if (INFINITYFREE_HOSTING) {
    // Konfigurasi khusus InfinityFree
    ini_set('max_execution_time', 300);
    ini_set('memory_limit', '256M');
    ini_set('upload_max_filesize', '32M');
    ini_set('post_max_size', '32M');
    
    // Jika berada di lingkungan produksi InfinityFree
    if (!isset($_ENV['APP_ENV']) || $_ENV['APP_ENV'] !== 'local') {
        // Nonaktifkan debug untuk produksi
        $_ENV['APP_DEBUG'] = 'false';
        $_ENV['APP_ENV'] = 'production';
        
        // Set timezone Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
    }
}

// Tambahkan konfigurasi tambahan jika diperlukan
if (isset($_SERVER['DOCUMENT_ROOT'])) {
    // Pastikan folder storage dan cache dapat ditulis
    $storagePath = $_SERVER['DOCUMENT_ROOT'] . '/../storage';
    $bootstrapCachePath = $_SERVER['DOCUMENT_ROOT'] . '/../bootstrap/cache';
    
    if (!is_writable($storagePath)) {
        @chmod($storagePath, 0755);
    }
    if (!is_writable($bootstrapCachePath)) {
        @chmod($bootstrapCachePath, 0755);
    }
}