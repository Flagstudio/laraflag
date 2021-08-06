<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class JobGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:job';

    protected $description = 'Create a new Job class';

    protected string $fileType = 'Job';

    protected string $pathStructure = '{container-name}/Jobs/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'job.stub';

    public array $inputs = [];

    public function getUserInputs(): array
    {
        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name'  => $this->containerName,
                'class-name'      => $this->fileName,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'DefaultJob';
    }
}
