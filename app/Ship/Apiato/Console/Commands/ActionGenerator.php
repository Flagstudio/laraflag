<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ActionGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:action';

    protected $description = 'Create a Action file for a Container';

    protected string $fileType = 'Action';

    protected string $pathStructure = '{container-name}/Actions/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'actions/generic.stub';

    public array $inputs = [
        ['model', null, InputOption::VALUE_OPTIONAL, 'The model this action is for.'],
        ['stub', null, InputOption::VALUE_OPTIONAL, 'The stub file to load for this generator.'],
    ];

    public function getUserInputs(): array
    {
        $this->stubName = 'action.stub';

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
        return 'DefaultAction';
    }
}
