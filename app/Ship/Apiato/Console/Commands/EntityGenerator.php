<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class EntityGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:entity';

    protected $description = 'Create a new Entity class';

    protected string $fileType = 'Entity';

    protected string $pathStructure = '{container-name}/Domain/Entities/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'entity.stub';

    public array $inputs = [];

    public function getUserInputs(): array
    {
        $this->warn('Generating Repository class');
        $this->call('flag:repository', [
            '--container' => $this->containerName,
            '--file' => Str::finish($this->fileName, 'Repository'),
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
}
