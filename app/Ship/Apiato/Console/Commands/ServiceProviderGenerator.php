<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ServiceProviderGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:provider';

    protected $description = 'Create a ServiceProvider for a Container';

    protected string $fileType = 'ServiceProvider';

    protected string $pathStructure = '{container-name}/Providers/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'providers/generic.stub';

    public array $inputs = [
        ['stub', null, InputOption::VALUE_OPTIONAL, 'The stub file to load for this generator.'],
    ];

    public function getUserInputs(): array
    {
        $stub = Str::lower(
            $this->checkParameterOrChoice(
                'stub',
                'Select the Stub you want to load',
                ['Generic', 'Event'],
                0
            )
        );

        $this->stubName = 'providers/' . $stub . '.stub';

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'ServiceProvider';
    }
}
