<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class TestGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flag:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a TestCase for a Container';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'TestCase';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{container-name}/Tests/{type}/*';

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
    protected $stubName = 'test.stub';

    /**
     * User required/optional inputs expected to be passed while calling the command.
     * This is a replacement of the `getArguments` function "which reads whenever it's called".
     *
     * @var  array
     */
    public $inputs = [
        ['type', null, InputOption::VALUE_OPTIONAL, 'The type to generate the TestCase for.'],
    ];

    /**
     * @return array
     */
    public function getUserInputs()
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

    /**
     * Get the default file name for this component to be generated
     *
     * @return string
     */
    public function getDefaultFileName()
    {
        return 'ExampleTest';
    }
}
