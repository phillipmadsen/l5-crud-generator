<?php
namespace Phillips\Generator;


class TemplatesHelper
{
	public function getTemplate($template, $type = "Common")
	{
		$path = base_path('resources/api-generator-templates/' . $type . '/' . $template . '.txt');
		if(!file_exists($path))
		{
			$path = base_path('vendor/phillips/laravel-api-generator/src/Phillips/Generator/Templates/' . $type . '/' . $template . '.txt');
		}

		$fileData = file_get_contents($path);

		return $fileData;
	}
}