<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class TestGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:test';

    protected $description = 'Create a TestCase for a Container';

    protected string $fileType = 'Test';

    protected string $pathStructure = '{container-name}/Tests/{type}/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'test.stub';

    public array $inputs = [
        ['type', null, InputOption::VALUE_OPTIONAL, 'The type to generate the TestCase for.'],
    ];

    public function getUserInputs(): array
    {
        $type = $this->checkParameterOrChoice(
            'type',
            'Select the the for the TestCase',
            ['Unit', 'Feature'],
            0,
        );

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
                'type' => $type,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'type' => $type,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'ExampleTest';
    }
}
