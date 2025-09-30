<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class BackupController extends Controller
{
    public function backup()
    {
        try {
            $connection = config('database.default');

            // Ensure backups directory exists
            $backupsDir = storage_path('app/backups');
            if (!file_exists($backupsDir)) {
                mkdir($backupsDir, 0755, true);
            }

            if (in_array($connection, ['mysql', 'mariadb'])) {
                $database = config("database.connections.{$connection}.database");
                $username = config("database.connections.{$connection}.username");
                $password = config("database.connections.{$connection}.password");
                $host = config("database.connections.{$connection}.host");
                $port = config("database.connections.{$connection}.port", '3306');

                $filename = 'backup_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sql';
                $filepath = $backupsDir . DIRECTORY_SEPARATOR . $filename;

                // Prefer explicit mysqldump path on Windows/XAMPP; fallback to PATH
                $defaultDumpPath = 'C:/xampp/mysql/bin/mysqldump.exe';
                $mysqldump = file_exists($defaultDumpPath) ? $defaultDumpPath : 'mysqldump';

                // Build command with safe quoting; use --result-file to avoid shell redirection quirks on Windows
                $command = '"' . $mysqldump . '"'
                    . ' --host="' . $host . '"'
                    . ' --port="' . $port . '"'
                    . ' --user="' . $username . '"'
                    . ' --password="' . $password . '"'
                    . ' --routines --triggers --databases "' . $database . '"'
                    . ' --result-file="' . $filepath . '" 2>&1';

                $output = [];
                $return_var = 1;
                exec($command, $output, $return_var);

                // Consider backup successful only if file exists and has size
                if ($return_var === 0 && file_exists($filepath) && filesize($filepath) > 0) {
                    $xamppDataDir = 'C:/xampp/mysql/data/';
                    if (is_dir($xamppDataDir)) {
                        @copy($filepath, $xamppDataDir . $filename);
                    }

                    return response()->download($filepath, $filename)->deleteFileAfterSend(true);
                }

                $errorMessage = 'Failed to create database backup.';
                if (!empty($output)) {
                    $errorMessage .= ' ' . implode("\n", array_slice($output, -5));
                }
                return redirect()->back()->with('error', $errorMessage);
            }

            if ($connection === 'sqlite') {
                $sqlitePath = config('database.connections.sqlite.database');
                if (!is_string($sqlitePath) || !file_exists($sqlitePath)) {
                    return redirect()->back()->with('error', 'SQLite database file not found.');
                }

                $filename = 'backup_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sqlite';
                $filepath = $backupsDir . DIRECTORY_SEPARATOR . $filename;
                if (!@copy($sqlitePath, $filepath)) {
                    return redirect()->back()->with('error', 'Failed to copy SQLite database file.');
                }

                return response()->download($filepath, $filename)->deleteFileAfterSend(true);
            }

            return redirect()->back()->with('error', 'Unsupported database connection for backup: ' . $connection);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating backup: ' . $e->getMessage());
        }
    }
}

