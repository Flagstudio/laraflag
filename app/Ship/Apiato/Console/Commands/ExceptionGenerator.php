<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class ExceptionGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:exception';

    protected $description = 'Create a new Exception class';

    protected string $fileType = 'Exception';

    protected string $pathStructure = '{container-name}/Exceptions/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'exception.stub';

    public array $inputs = [];

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
