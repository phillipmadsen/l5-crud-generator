<?php

namespace Phillips\Generator;

use Illuminate\Support\ServiceProvider;
use Phillips\Generator\Commands\APIGeneratorCommand;
use Phillips\Generator\Commands\PublishBaseControllerCommand;
use Phillips\Generator\Commands\ScaffoldAPIGeneratorCommand;
use Phillips\Generator\Commands\ScaffoldGeneratorCommand;

class GeneratorServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configPath = __DIR__ . '/../../../config/generator.php';
		$this->publishes([$configPath => config_path('generator.php')], 'config');
		$this->publishes([
			__DIR__ . '/../../../views' => base_path('resources/views'),
		], 'config');
		$this->publishes([
			__DIR__ . '/Templates' => base_path('resources/api-generator-templates'),
		], 'templates');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('phillips.generator.api', function ($app)
		{
			return new APIGeneratorCommand();
		});

		$this->app->singleton('phillips.generator.scaffold', function ($app)
		{
			return new ScaffoldGeneratorCommand();
		});

		$this->app->singleton('phillips.generator.scaffold_api', function ($app)
		{
			return new ScaffoldAPIGeneratorCommand();
		});

		$this->app->singleton('phillips.generator.publish.base_controller', function ($app)
		{
			return new PublishBaseControllerCommand();
		});

		$this->commands(['phillips.generator.api', 'phillips.generator.scaffold', 'phillips.generator.scaffold_api', 'phillips.generator.publish.base_controller']);
	}
}
