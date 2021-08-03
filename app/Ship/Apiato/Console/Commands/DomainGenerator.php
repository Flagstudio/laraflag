<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class DomainGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flag:domain';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Domain class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected string $fileType = 'Domain';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected string $pathStructure = '{container-name}/Domain/Entities/*';

    /**
     * The structure of the file name.
     *
     * @var  string
     */
    protected string $nameStructure = '{file-name}';

    /**
     * The name of the stub file.
     *
     * @var  string
     */
    protected string $stubName = 'entity.stub';

    /**
     * User required/optional inputs expected to be passed while calling the command.
     * This is a replacement of the `getArguments` function "which reads whenever it's called".
     *
     * @var  array
     */
    public array $inputs = [
        ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the domain'],
        ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the domain'],
        ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the domain'],
        ['seed', 's', InputOption::VALUE_NONE, 'Create a new seeder file for the domain'],
        ['resource', 'r', InputOption::VALUE_NONE, 'Create a new resource file for the domain'],
//        ['repository', 'q', InputOption::VALUE_NONE, 'Create a new repository file for the domain'],
        ['policy', 'p', InputOption::VALUE_NONE, 'Create a new policy file for the domain'],
    ];

    public function handle(): int
    {
        $this->validateGenerator($this);

        $this->containerName = ucfirst($this->checkParameterOrAsk('container', 'Enter the name of the Container'));
        $this->fileName = $this->containerName = $this->removeSpecialChars($this->containerName);

        $options = $this->getSelectedOptions();

        foreach ($options as $name => $option) {
            $this->{$name . 'Maker'}();
        }

        $this->warn('Generating configuration file');
        $this->call('flag:config', [
            '--container'   => $this->containerName,
            '--file'        => Str::lower($this->containerName),
        ]);

        // exit the command successfully
        return 0;
    }

    /**
     * @return array
     */
    public function getUserInputs(): array
    {
        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'resource-key' => strtolower(Pluralizer::plural($this->fileName)),
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getSelectedOptions(): Collection
    {
        return collect($this->options())
            ->filter(fn ($item): bool => $item === true);
    }

    public function controllerMaker(): void
    {
        $this->warn('Generating Controller');
        $this->call('flag:controller', [
            '--container' => $this->containerName,
            '--file' => $this->fileName . 'Controller',
        ]);
    }

    public function factoryMaker(): void
    {
        $this->warn('Generating Factory');
        $this->call('flag:factory', [
            '--container' => $this->containerName,
            '--file' => $this->fileName . 'Factory',
            '--model' => $this->fileName,
        ]);
    }

    public function migrationMaker(): void
    {
        $this->warn('Generating Migration');
        $this->call('flag:factory', [
            '--container' => $this->containerName,
            '--file' => "Create{$this->fileName}Table",
            '--tablename' => Str::plural(Str::lower($this->fileName)),
            '--stub' => 1,
        ]);
    }

    public function seedMaker(): void
    {
        //TODO
    }

    public function resourceMaker(): void
    {
        //TODO
    }

    public function policyMaker(): void
    {
        //TODO
    }
}
