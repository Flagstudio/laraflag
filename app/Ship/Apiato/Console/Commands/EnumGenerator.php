<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class EnumGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flag:enum';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Enum class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'Enum';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{container-name}/Domain/Enums/{entity}/*';

    /**
     * The structure of the file name.
     *
     * @var  string
     */
    protected $nameStructure = '{file-name}';

    /**
     * The name of the stub file.
     *
     * @var  string
     */
    protected $stubName = 'enum.stub';

    public $inputs = [];

    /**
     * @return array
     */
    public function getUserInputs()
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
