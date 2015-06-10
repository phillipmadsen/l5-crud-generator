<?php
namespace Phillips\Generator\Commands;

use Illuminate\Console\Command;
use Phillips\Generator\File\FileHelper;
use Phillips\Generator\TemplatesHelper;
use Symfony\Component\Console\Input\InputArgument;

class PublishBaseControllerCommand extends Command
{
 
	protected $name = 'phillips.generator.publish:base_controller';

	 
	protected $description = 'Create a full Addon/CRUD API for given section/model';
 
	public function handle()
	{
		$namespace = $this->argument('namespace');

		$templateHelper = new TemplatesHelper();
		$templateData = $templateHelper->getTemplate('AppBaseController', 'Controller');

		$templateData = str_replace('$$BASE_NAMESPACE$$', $namespace, $templateData);

		$fileName = "AppBaseController.php";

		$filePath = __DIR__ . "/../../Controller/";

		$fileHelper = new FileHelper();
		$fileHelper->writeFile($filePath . $fileName, $templateData);
		$this->comment('AppBaseController generated');
		$this->info($fileName);
	}
 
	protected function getArguments()
	{
		return [
			['namespace', InputArgument::REQUIRED, 'Base Controller namespace']
		];
	}

	 
	public function getOptions()
	{
		return [];
	}
}
