<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class EnumGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:enum';

    protected $description = 'Create a new Enum class';

    protected string $fileType = 'Enum';

    protected string $pathStructure = '{container-name}/Domain/Enums/{entity}/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'enum.stub';

    public array $inputs = [];

    public function getUserInputs(): array
    {
        $entity = Str::remove($this->fileType, $this->fileName);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
                'entity' => $entity,
            ],
            'stub-parameters' => [
                'container-name' => $this->containerName,
                'class-name' => Str::finish($this->fileName, $this->fileType),
                'entity-name' => $entity,
            ],
            'file-parameters' => [
                'file-name' => Str::finish($this->fileName, $this->fileType),
            ],
        ];
    }
}
