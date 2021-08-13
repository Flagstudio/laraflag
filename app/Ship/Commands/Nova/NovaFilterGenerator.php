<?php

namespace App\Ship\Commands\Nova;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class NovaFilterGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'nova:filter';

    protected $description = 'Create a new Nova Filter class';

    protected string $fileType = '';

    protected string $pathStructure = '{container-name}/Nova/Filters/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'filter.stub';

    public array $inputs = [];

    protected function getStubPath(): string
    {
        return 'Commands/Nova/Stubs/' . $this->stubName;
    }

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
