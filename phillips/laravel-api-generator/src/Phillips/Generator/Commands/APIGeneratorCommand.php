<?php

namespace Phillips\Generator\Commands;

use Phillips\Generator\CommandData;
use Phillips\Generator\Generators\API\APIControllerGenerator;
use Phillips\Generator\Generators\API\RepoAPIControllerGenerator;
use Phillips\Generator\Generators\Common\MigrationGenerator;
use Phillips\Generator\Generators\Common\ModelGenerator;
use Phillips\Generator\Generators\Common\RepositoryGenerator;
use Phillips\Generator\Generators\Common\RoutesGenerator;
use Symfony\Component\Console\Input\InputArgument;

class APIGeneratorCommand extends BaseCommand
{

	 
	protected $name = 'phillips.generator:api';

 
	protected $description = 'Create a full Addon/CRUD API for given section/model';

	 
	public function __construct()
	{
		parent::__construct();

		$this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_API);
	}

	 
	public function handle()
	{
		parent::handle();

		$followRepoPattern = $this->confirm("\nDo you want to generate repository ? (y|N)", false);

		$migrationGenerator = new MigrationGenerator($this->commandData);
		$migrationGenerator->generate();

		$modelGenerator = new ModelGenerator($this->commandData);
		$modelGenerator->generate();

		if($followRepoPattern)
		{
			$repositoryGenerator = new RepositoryGenerator($this->commandData);
			$repositoryGenerator->generate();

			$repoControllerGenerator = new RepoAPIControllerGenerator($this->commandData);
			$repoControllerGenerator->generate();
		}
		else
		{
			$controllerGenerator = new APIControllerGenerator($this->commandData);
			$controllerGenerator->generate();
		}

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
