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
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            
            $filename = 'backup_' . Carbon::now()->format('Y_m_d_H_i_s') . '.sql';
            $filepath = storage_path('app/backups/' . $filename);
            
            // Create backups directory if it doesn't exist
            if (!file_exists(storage_path('app/backups'))) {
                mkdir(storage_path('app/backups'), 0755, true);
            }
            
            // Create mysqldump command
            $command = "mysqldump --host={$host} --user={$username} --password={$password} {$database} > {$filepath}";
            
            // Execute the command
            exec($command, $output, $return_var);
            
            if ($return_var === 0 && file_exists($filepath)) {
                // Copy to XAMPP directory (adjust path as needed)
                $xamppPath = 'C:/xampp/mysql/data/' . $filename;
                copy($filepath, $xamppPath);
                
                // Return the file for download
                return response()->download($filepath, $filename)->deleteFileAfterSend(true);
            } else {
                return redirect()->back()->with('error', 'Failed to create database backup.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating backup: ' . $e->getMessage());
        }
    }
}

