<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
//use Illuminate\Support\Str;

class TraitCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'make:trait {name}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a new trait';

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

		if($this->alreadyExists($this->getNameInput())) {
			$this->error('Trait already exists!');
			return false;
		}

		$this->makeDirectory($path);
		$this->files->put($path, $this->buildTrait($name));

		$this->info('Trait created successfully.');
	}

	protected function getNameInput() {
		return trim($this->argument('name'));
	}

	protected function getDirPath() {
		return app_path('Http'.DIRECTORY_SEPARATOR.'Traits');
	}

	protected function getPath($name) {
		return $this->getDirPath().DIRECTORY_SEPARATOR.str_replace('\\', DIRECTORY_SEPARATOR, $name).'.php';
	}

	protected function alreadyExists($rawName) {
		return $this->files->exists($this->getPath($rawName));
	}

	protected function makeDirectory($path) {
		if(!$this->files->isDirectory(dirname($path))) {
			$this->files->makeDirectory(dirname($path), 0755, true, true);
		}

		return $path;
	}

	protected function qualifyClass($name){
		return $name;
	}

	protected function getNamespace($name){
		$namespace = trim(implode('\\', array_slice(explode('\\', $name), 0, -1)), '\\');
		return $namespace ? '\\' .$namespace : '';
	}

	protected function rootNamespace(){
		return str_replace('\\', '', $this->laravel->getNamespace());
	}

	protected function getDefaultNamespace($rootNamespace)
	{
		$path = str_replace(app_path(), '', $this->getDirPath());
		return $rootNamespace .'\\' .trim(implode('\\', array_slice(explode(DIRECTORY_SEPARATOR, $path), 1)), '\\');
	}

	protected function replaceNamespace(&$stub, $name) {
		$stub = str_replace(
			['DummyDefaultNamespace', 'DummyNamespace'],
			[$this->getDefaultNamespace($this->rootNamespace()), $this->getNamespace($name)],
			$stub
		);

		return $this;
	}

	protected function replaceTrait($stub, $name)
	{
		$class = explode('\\',$name);
		return str_replace('DummyTrait', array_pop($class), $stub);
	}

	protected function buildTrait($name) {
		$stub = $this->files->get(__DIR__.'/Stubs/Trait.stub');
		return $this->replaceNamespace($stub, $name)->replaceTrait($stub, $name);
	}

}
