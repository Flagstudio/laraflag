<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class RepositoryGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:repository';

    protected $description = 'Create a new Repository class';

    protected string $fileType = 'Repository';

    protected string $pathStructure = '{container-name}/Domain/Repositories/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'repository.stub';

    public array $inputs = [
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
}
