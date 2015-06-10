<?php
namespace Phillips\Generator\Commands;

use Exception;
use Illuminate\Console\Command;
use Phillips\Generator\CommandData;
use Phillips\Generator\File\FileHelper;
use Phillips\Generator\Utils\GeneratorUtils;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BaseCommand extends Command
{
 
	public $commandData;

	public function handle()
	{
		$this->commandData->modelName = $this->argument('model');
		$this->commandData->useSoftDelete = $this->option('softDelete');
		$this->commandData->useSearch = $this->option('search');
		$this->commandData->fieldsFile = $this->option('fieldsFile');
		$this->commandData->initVariables();
		if($this->commandData->fieldsFile)
		{
			$fileHelper = new FileHelper();
			try
			{
				if(file_exists($this->commandData->fieldsFile))
					$filePath = $this->commandData->fieldsFile;
				else
					$filePath = base_path($this->commandData->fieldsFile);

				if(!file_exists($filePath))
				{
					$this->commandData->commandObj->error("Fields file not found");
					exit;
				}

				$fileContents = $fileHelper->getFileContents($filePath);
				$fields = json_decode($fileContents, true);

				$this->commandData->inputFields = GeneratorUtils::validateFieldsFile($fields);
			}
			catch(Exception $e)
			{
				$this->commandData->commandObj->error($e->getMessage());
				exit;
			}
		}
		else
			$this->commandData->inputFields = $this->commandData->getInputFields();
	}

	 
	protected function getArguments()
	{
		return [
			['model', InputArgument::REQUIRED, 'Singular Model name']
		];
	}
 
	public function getOptions()
	{
		return [
			['softDelete', null, InputOption::VALUE_NONE, 'Use Soft Delete trait'],
			['search', null, InputOption::VALUE_NONE, 'Add Search functionality to index'],
			['fieldsFile', null, InputOption::VALUE_REQUIRED, 'Fields input as json file']
		];
	}
}