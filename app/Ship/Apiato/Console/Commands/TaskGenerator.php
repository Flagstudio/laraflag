<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class TaskGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:task';

    protected $description = 'Create a Task file for a Container';

    protected string $fileType = 'Task';

    protected string $pathStructure = '{container-name}/Tasks/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'tasks/generic.stub';

    public array $inputs = [
        ['model', null, InputOption::VALUE_OPTIONAL, 'The model this task is for.'],
    ];

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
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'DefaultTask';
    }
}
