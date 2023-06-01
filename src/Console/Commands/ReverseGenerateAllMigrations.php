<?php

namespace KabirIbi\ReverseGenerateMigrations\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ReverseGenerateAllMigrations extends Command
{
	protected $signature = 'reverse:generate-all-migrations';

	protected $description = 'Reverse generates migration files with collation and charset for all tables in the database';

	public function handle()
	{
		$connection = config('database.default');
		$tables = DB::connection($connection)->getDoctrineSchemaManager()->listTableNames();

		foreach ($tables as $table) {
			$columns = Schema::getColumnListing($table);

			$tableDetails = DB::connection($connection)->getDoctrineSchemaManager()->listTableDetails($table);
			$options = $tableDetails->getOptions();
			$collation = isset($options['collation']) ? $options['collation'] : '';
			if($collation != '') $collation = "\$table->collation('$collation');";
			$charset = isset($options['charset']) ? $options['charset'] : '';
			if($charset != '') $charset = "\$table->charset('$charset');";

			$migrationFileName = 'create_' . $table . '_table';
			$migrationPath = database_path('migrations') . '/' . date('Y_m_d_His') . '_' . $migrationFileName . '.php';

			$stub = file_get_contents(base_path('vendor/kabir-ibi/laravel-reverse-generate-migrations/src/stubs/create_table.stub'));

			$columnDefinitions = '';
			foreach ($columns as $column) {
				$columnDefinition = Schema::getColumnType($table, $column);
				$columnDefinitions .= "\$table->$columnDefinition('$column');\n			";
			}

			$stub = str_replace(
				['{{ class }}', '{{ table }}', '{{ columns }}', '{{ charset }}', '{{ collation }}'],
				[$migrationFileName, $table, $columnDefinitions, $charset, $collation],
				$stub
			);

			file_put_contents($migrationPath, $stub);
		}

		$this->info('All migrations generated successfully.');
	}
}
