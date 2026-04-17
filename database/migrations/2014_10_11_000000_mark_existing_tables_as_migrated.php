<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MarkExistingTablesAsMigrated extends Migration
{
    /**
     * If tables already exist (e.g. from previous setup), mark their migrations as run
     * so "php artisan migrate" does not try to create them again.
     */
    public function up()
    {
        $batch = (int) DB::table('migrations')->max('batch') + 1;
        $toInsert = [];

        if (Schema::hasTable('users')) {
            $toInsert[] = ['migration' => '2014_10_12_000000_create_users_table', 'batch' => $batch];
        }
        if (Schema::hasTable('password_resets')) {
            $toInsert[] = ['migration' => '2014_10_12_100000_create_password_resets_table', 'batch' => $batch];
        }
        if (Schema::hasTable('failed_jobs')) {
            $toInsert[] = ['migration' => '2019_08_19_000000_create_failed_jobs_table', 'batch' => $batch];
        }
        if (Schema::hasTable('personal_access_tokens')) {
            $toInsert[] = ['migration' => '2019_12_14_000001_create_personal_access_tokens_table', 'batch' => $batch];
        }

        $existing = DB::table('migrations')->pluck('migration')->toArray();
        foreach ($toInsert as $row) {
            if (!in_array($row['migration'], $existing, true)) {
                DB::table('migrations')->insert($row);
                $existing[] = $row['migration'];
            }
        }
    }

    public function down()
    {
        DB::table('migrations')->whereIn('migration', [
            '2014_10_12_000000_create_users_table',
            '2014_10_12_100000_create_password_resets_table',
            '2019_08_19_000000_create_failed_jobs_table',
            '2019_12_14_000001_create_personal_access_tokens_table',
        ])->delete();
    }
}
