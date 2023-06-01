<?php

namespace KabirIbi\ReverseGenerateMigrations\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReverseGenerateAllMigrations extends Command
{
	protected $signature = 'reverse:generate-all-migrations';

	protected $description = 'Reverse generates migration files with collation and charset for all tables in the database';

	public function handle()
	{
		$connection = config('database.default');
		$tables = DB::connection($connection)->getDoctrineSchemaManager()->listTableNames();

		foreach ($tables as $table) {
			$collation = DB::connection($connection)->getDoctrineSchemaManager()->listTableDetails($table)->getOptions()['collation'];
			$charset = DB::connection($connection)->getDoctrineSchemaManager()->listTableDetails($table)->getOptions()['charset'];

			$migrationFileName = 'create_' . $table . '_table';

			$migrationPath = database_path('migrations') . '/' . date('Y_m_d_His') . '_' . $migrationFileName . '.php';

			$stub = file_get_contents(base_path('vendor/laravel/framework/src/Illuminate/Database/Migrations/stubs/create.stub'));

			$stub = str_replace(
				['DummyClass', 'DummyTable', 'DummyCollation', 'DummyCharset'],
				[$migrationFileName, $table, $collation, $charset],
				$stub
			);

			file_put_contents($migrationPath, $stub);
		}

		$this->info('All migrations generated successfully.');
	}
}
