<?php
namespace Phillips\Generator\Commands;

use Phillips\Generator\CommandData;
use Phillips\Generator\Generators\Common\MigrationGenerator;
use Phillips\Generator\Generators\Common\ModelGenerator;
use Phillips\Generator\Generators\Common\RepositoryGenerator;
use Phillips\Generator\Generators\Common\RequestGenerator;
use Phillips\Generator\Generators\Common\RoutesGenerator;
use Phillips\Generator\Generators\Scaffold\RepoViewControllerGenerator;
use Phillips\Generator\Generators\Scaffold\ViewControllerGenerator;
use Phillips\Generator\Generators\Scaffold\ViewGenerator;

class ScaffoldGeneratorCommand extends BaseCommand
{
 
	protected $name = 'phillips.generator:scaffold';
 
	protected $description = 'Create a full Addon/CRUD for given section/model with initial views';
 
	public function __construct()
	{
		parent::__construct();

		$this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD);
	}
 
	public function handle()
	{
		parent::handle();

		$followRepoPattern = $this->confirm("\nDo you want to generate repository ? (y|N)", false);

		$migrationGenerator = new MigrationGenerator($this->commandData);
		$migrationGenerator->generate();

		$modelGenerator = new ModelGenerator($this->commandData);
		$modelGenerator->generate();

		$requestGenerator = new RequestGenerator($this->commandData);
		$requestGenerator->generate();

		if($followRepoPattern)
		{
			$repositoryGenerator = new RepositoryGenerator($this->commandData);
			$repositoryGenerator->generate();

			$repoControllerGenerator = new RepoViewControllerGenerator($this->commandData);
			$repoControllerGenerator->generate();
		}
		else
		{
			$controllerGenerator = new ViewControllerGenerator($this->commandData);
			$controllerGenerator->generate();
		}

		$viewsGenerator = new ViewGenerator($this->commandData);
		$viewsGenerator->generate();

		$routeGenerator = new RoutesGenerator($this->commandData);
		$routeGenerator->generate();

		if($this->confirm("\nDo you want to migrate database? [y|N]", false))
			$this->call('migrate');
	}
 
	protected function getArguments()
	{
		return array_merge(parent::getArguments());
	}
 
	public function getOptions()
	{
		return array_merge(parent::getOptions(), []);
	}
}
