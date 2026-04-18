<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DatabaseBackupController extends Controller
{
    public function index()
    {
        $backupPath = storage_path('app/backups');
        
        // Create backup directory if not exists
        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0755, true);
        }

        // Get all backup files
        $backups = collect(File::files($backupPath))
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'date' => date('Y-m-d H:i:s', $file->getMTime()),
                    'path' => $file->getPathname(),
                ];
            })
            ->sortByDesc('date')
            ->values();

        return view('admin.backup.index', compact('backups'));
    }

    public function create()
    {
        try {
            $backupPath = storage_path('app/backups');
            
            // Create backup directory if not exists
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }

            // Get database configuration
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');

            // Generate filename with timestamp
            $filename = 'backup_' . $dbName . '_' . date('Y-m-d_His') . '.sql';
            $filepath = $backupPath . '/' . $filename;

            // mysqldump command
            $command = sprintf(
                'mysqldump --host=%s --port=%s --user=%s --password=%s %s > %s 2>&1',
                escapeshellarg($dbHost),
                escapeshellarg($dbPort),
                escapeshellarg($dbUser),
                escapeshellarg($dbPass),
                escapeshellarg($dbName),
                escapeshellarg($filepath)
            );

            // Execute backup
            exec($command, $output, $returnVar);

            if ($returnVar !== 0 || !File::exists($filepath) || File::size($filepath) === 0) {
                // Fallback: Use Laravel's database backup
                $this->createBackupFallback($filepath, $dbName);
            }

            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup database berhasil dibuat: ' . $filename);

        } catch (\Exception $e) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    private function createBackupFallback($filepath, $dbName)
    {
        // Alternative backup method using PHP
        $tables = \DB::select('SHOW TABLES');
        $sql = "-- Database Backup\n";
        $sql .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";
        $sql .= "SET FOREIGN_KEY_CHECKS=0;\n\n";

        foreach ($tables as $table) {
            $tableName = array_values((array)$table)[0];
            
            // Drop table
            $sql .= "DROP TABLE IF EXISTS `{$tableName}`;\n";
            
            // Create table
            $createTable = \DB::select("SHOW CREATE TABLE `{$tableName}`")[0];
            $sql .= $createTable->{'Create Table'} . ";\n\n";
            
            // Insert data
            $rows = \DB::table($tableName)->get();
            if ($rows->count() > 0) {
                foreach ($rows as $row) {
                    $values = array_map(function($value) {
                        return is_null($value) ? 'NULL' : "'" . addslashes($value) . "'";
                    }, (array)$row);
                    
                    $sql .= "INSERT INTO `{$tableName}` VALUES (" . implode(', ', $values) . ");\n";
                }
                $sql .= "\n";
            }
        }

        $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
        
        File::put($filepath, $sql);
    }

    public function download($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (!File::exists($filepath)) {
            return redirect()->route('admin.backup.index')
                ->with('error', 'File backup tidak ditemukan!');
        }

        return response()->download($filepath);
    }

    public function destroy($filename)
    {
        $filepath = storage_path('app/backups/' . $filename);

        if (File::exists($filepath)) {
            File::delete($filepath);
            return redirect()->route('admin.backup.index')
                ->with('success', 'Backup berhasil dihapus!');
        }

        return redirect()->route('admin.backup.index')
            ->with('error', 'File backup tidak ditemukan!');
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
