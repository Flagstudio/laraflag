<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class DomainGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:domain';

    protected $description = 'Create a new Domain class';

    protected string $fileType = 'Domain';

    protected string $pathStructure = '{container-name}/Domain/Entities/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'entity.stub';

    public array $inputs = [
        ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the domain'],
        ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the domain'],
        ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the domain'],
    ];

    public function handle(): int
    {
        $this->validateGenerator($this);

        $this->containerName = $this->argument('container')
            ?? ucfirst($this->checkParameterOrAsk('container', 'Enter the name of the Container'));
        $this->fileName = $this->containerName = $this->removeSpecialChars($this->containerName);

        $this->warn('Generating configuration file');
        $this->call('flag:config', [
            '--container' => $this->containerName,
            '--file' => Str::lower($this->containerName),
        ]);

        $this->warn('Generating Entity file');
        $this->call('flag:entity', [
            '--container' => $this->containerName,
            '--file' => $this->fileName,
        ]);

        $this->warn('Generating Routes file');
        $this->call('flag:route', [
            '--container' => $this->containerName,
            '--file' => $this->fileName,
            '--stub' => 'all',
        ]);

        // exit the command successfully
        return 0;
    }

    public function getUserInputs(): array
    {
        return [];
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
