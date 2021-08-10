<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class EntityGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:entity';

    protected $description = 'Create a new Entity class';

    protected string $fileType = 'Entity';

    protected string $pathStructure = '{container-name}/Domain/Entities/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'entity.stub';

    public array $inputs = [
        ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the domain'],
        ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the domain'],
        ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the domain'],
    ];

    public function getUserInputs(): array
    {
        $this->warn('Generating Repository class');
        $this->call('flag:repository', [
            '--container' => $this->containerName,
            '--file' => Str::finish($this->fileName, 'Repository'),
        ]);

        $this->warn('Generating Migration file');
        $this->call('flag:migration', [
            '--container' => $this->containerName,
            '--file' => 'create_' . Str::lower($this->fileName) . '_table',
            '--tablename' => Str::plural($this->fileName),
            '--stub' => 'create',
        ]);

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
            '--stub' => 'create',
        ]);
    }
}
