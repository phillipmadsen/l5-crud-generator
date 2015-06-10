<?php
namespace Phillips\Generator\Commands;

use Phillips\Generator\CommandData;
use Phillips\Generator\Generators\API\RepoAPIControllerGenerator;
use Phillips\Generator\Generators\Common\MigrationGenerator;
use Phillips\Generator\Generators\Common\ModelGenerator;
use Phillips\Generator\Generators\Common\RepositoryGenerator;
use Phillips\Generator\Generators\Common\RequestGenerator;
use Phillips\Generator\Generators\Common\RoutesGenerator;
use Phillips\Generator\Generators\Scaffold\RepoViewControllerGenerator;
use Phillips\Generator\Generators\Scaffold\ViewGenerator;
use Symfony\Component\Console\Input\InputArgument;

class ScaffoldAPIGeneratorCommand extends BaseCommand
{
	 
	protected $name = 'phillips.generator:scaffold_api';
	 
	protected $description = 'Create a full Addon/CRUD for given section/model with initial views and APIs';

	 
	public function __construct()
	{
		parent::__construct();
		$this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD_API);
	}

	 
	public function handle()
	{
		parent::handle();

		$migrationGenerator = new MigrationGenerator($this->commandData);
		$migrationGenerator->generate();

		$modelGenerator = new ModelGenerator($this->commandData);
		$modelGenerator->generate();

		$requestGenerator = new RequestGenerator($this->commandData);
		$requestGenerator->generate();

		$repositoryGenerator = new RepositoryGenerator($this->commandData);
		$repositoryGenerator->generate();

		$repoControllerGenerator = new RepoAPIControllerGenerator($this->commandData);
		$repoControllerGenerator->generate();

		$viewsGenerator = new ViewGenerator($this->commandData);
		$viewsGenerator->generate();

		$repoControllerGenerator = new RepoViewControllerGenerator($this->commandData);
		$repoControllerGenerator->generate();

		$routeGenerator = new RoutesGenerator($this->commandData);
		$routeGenerator->generate();

		if($this->confirm("\nDo you want to migrate database? [y|N]", false))
			$this->call('migrate');
	}

	 
	protected function getArguments()
	{
		return array_merge(parent::getArguments(), []);
	}

	 
	public function getOptions()
	{
		return array_merge(parent::getOptions(), []);

	}
}