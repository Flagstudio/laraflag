<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class FactoryGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:factory';

    protected $description = 'Create a new Factory for Model';

    protected string $fileType = 'Factory';

    protected string $pathStructure = '{container-name}/Domain/Factories/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'factory.stub';

    public array $inputs = [
        ['model', null, InputOption::VALUE_OPTIONAL, 'The name of Entities'],
    ];

    public function getUserInputs(): array
    {
        $model = $this->checkParameterOrAsk('model', 'Enter the name of Model');

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'model-name' => $model,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
