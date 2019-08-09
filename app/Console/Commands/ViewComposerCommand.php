<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ViewComposerCommand extends Command
{
	protected $files;
	protected $config;
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'make:composer {name}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new view composer class';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Filesystem $files)
	{
		$this->files = $files;
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$name = $this->qualifyClass($this->getNameInput());
		$path = $this->getPath($name);

		if($this->alreadyExists($this->getNameInput())){
			$this->error('View composer already exists!');
			return false;
		}

		$this->makeDirectory($path);
		$this->files->put($path, $this->buildClass($name));

		$this->info('View composer created successfully.');
	}

	protected function getNameInput() {
		return trim($this->argument('name'));
	}


	protected function getDirPath() {
		return app_path('Http'.DIRECTORY_SEPARATOR.'ViewComposers');
	}

	protected function getPath($name) {
		return $this->getDirPath().DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
	}

	protected function makeDirectory($path) {
		if(!$this->files->isDirectory(dirname($path))) {
			$this->files->makeDirectory(dirname($path), 0755, true, true);
		}

		return $path;
	}

	protected function alreadyExists($rawName) {
		return $this->files->exists($this->getPath($rawName));
	}


	protected function buildClass($name) {
		$stub = $this->files->get(__DIR__.'/Stubs/ViewComposer.stub');
//        dd(__DIR__.'/stubs/view.composer.stub');
		return $this->replaceNamespace($stub, $name)->replaceClass($stub, $name);
	}

	protected function replaceNamespace(&$stub, $name)
	{
		$stub = str_replace(
			['DummyDefaultNamespace', 'DummyNamespace'],
			[$this->getDefaultNamespace($this->rootNamespace()), $this->getNamespace($name)],
			$stub
		);
		return $this;
	}

	protected function getNamespace($name)
	{
		$namespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
		return $namespace ? '\\' .$namespace : '';
	}

	protected function rootNamespace()
	{
		return str_replace('\\', '', $this->laravel->getNamespace());
	}

	protected function getDefaultNamespace($rootNamespace)
	{
		$path = str_replace(app_path(), '', $this->getDirPath());
		return $rootNamespace .'\\' .trim(implode('\\', array_slice(explode(DIRECTORY_SEPARATOR, $path), 1)), '\\');
	}

	protected function replaceClass($stub, $name)
	{
		$class = explode('\\',$name);
		return str_replace('DummyClass', array_pop($class), $stub);
	}

	protected function qualifyClass($name) {
		return $name;
	}
}
