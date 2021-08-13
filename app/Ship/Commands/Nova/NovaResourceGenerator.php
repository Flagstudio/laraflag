<?php

namespace App\Ship\Commands\Nova;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class NovaResourceGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'nova:resource';

    protected $description = 'Create a new Nova Resource class';

    protected string $fileType = '';

    protected string $pathStructure = '{container-name}/Nova/Resources/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'resource.stub';

    public array $inputs = [
        ['group', 'g', InputOption::VALUE_NONE, 'Set group for resource'],
        ['groupName', null, InputOption::VALUE_NONE, 'Set group for resource'],
    ];

    protected function getStubPath(): string
    {
        return 'Commands/Nova/Stubs/' . $this->stubName;
    }

    public function getUserInputs(): array
    {
        $group = 'Other';
        if ($this->option('group') !== null) {
            $group = $this->checkParameterOrAsk('groupName', 'Enter the name of the group');
        }

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'group' => $group,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
