<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class ResponderGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:responder';

    protected $description = 'Create a Responder for a Container';

    protected string $fileType = 'Responder';

    protected string $pathStructure = '{container-name}/Transfers/Responders/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'responder.stub';

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

    public function getDefaultFileName(): string
    {
        return 'ExampleTest';
    }
}
