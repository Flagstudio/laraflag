<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class SeederGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:seeder';

    protected $description = 'Create a new Seeder class';

    protected string $fileType = 'Seeder';

    protected string $pathStructure = '{container-name}/Domain/Seeders/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'seeder.stub';

    public array $inputs = [
        ['factory', 'f', InputOption::VALUE_NONE, 'Create a new factory for the domain'],
        ['model', null, InputOption::VALUE_REQUIRED, 'Selected Model for seeder'],
    ];

    protected string $model;

    public function getUserInputs(): array
    {
        $this->model = $this->checkParameterOrAsk('model', 'Enter the name of the Model');

        if ($this->option('factory')) {
            $this->factoryMaker();
        }

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'model-name' => $this->model,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function factoryMaker(): void
    {
        $this->warn('Generating Factory');
        $this->call('flag:factory', [
            '--container' => $this->containerName,
            '--file' => $this->model . 'Factory',
            '--model' => $this->model,
        ]);
    }
}
