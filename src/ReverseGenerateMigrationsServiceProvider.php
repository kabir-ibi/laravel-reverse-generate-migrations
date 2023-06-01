<?php

namespace KabirIbi\ReverseGenerateMigrations;

use Illuminate\Support\ServiceProvider;

class ReverseGenerateMigrationsServiceProvider extends ServiceProvider
{
		/**
		 * Register any application services.
		 *
		 * @return void
		 */
		public function register()
		{
			if ($this->app->runningInConsole()) {
				$this->commands([
					Console\Commands\ReverseGenerateAllMigrations::class,
				]);
			}
		}
}
