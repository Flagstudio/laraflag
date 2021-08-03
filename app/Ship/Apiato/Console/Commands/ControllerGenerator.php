<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class ControllerGenerator extends GeneratorCommand implements ComponentsGenerator
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'flag:controller';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a controller for a container';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $fileType = 'Controller';

    /**
     * The structure of the file path.
     *
     * @var  string
     */
    protected $pathStructure = '{container-name}/Http/Controllers/*';

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
    protected $stubName = 'controllers/generic.stub';

    /**
     * The options which can be passed to the command. All options are optional. You do not need to pass the
     * "--container" and "--file" options, as they are globally handled. Just use the options which are specific to
     * this generator.
     *
     * @var  array
     */
    public $inputs = [
        ['ui', null, InputOption::VALUE_OPTIONAL, 'The user-interface to generate the Controller for.'],
        ['stub', null, InputOption::VALUE_OPTIONAL, 'The stub file to load for this generator.'],
        ['hasRequests', null, InputOption::VALUE_OPTIONAL, 'Generate the corresponding Controller for this Model?'],
        ['model', null, InputOption::VALUE_OPTIONAL, 'The Model for generate Requests for Controller.'],
    ];

    /**
     * @return  array
     */
    public function getUserInputs()
    {
//        $ui = Str::lower($this->checkParameterOrChoice('ui', 'Select the UI for the controller', ['API', 'WEB']));

        $stub = Str::lower(
            $this->checkParameterOrChoice(
                'stub',
                'Select the Stub you want to load',
                ['Generic', 'Invoke', 'Resource'],
                0
            )
        );

        if ($stub == 'resource') {
            $hasRequests = $this->checkParameterOrConfirm('hasRequests', 'Do you want to generate the corresponding Requests for this Controller?', true);
            if ($hasRequests) {
                $model = $this->checkParameterOrAsk('model', 'Enter the name of the Model file');
                $arrRequests = [
                    'store' => "Store{$model}Request",
                    'update' => "Update{$model}Request",
                ];

                $stub = 'resource.requests';

                foreach ($arrRequests as $request) {
                    $status = $this->call('flag:request', [
                        '--container' => $this->containerName,
                        '--file' => $request
                    ]);

                    if ($status == 0) {
                        $this->printInfoMessage('The Request was successfully generated');
                    } else {
                        $this->printErrorMessage('Could not generate the corresponding Request!');
                    }
                }
            }
        }

        // load a new stub-file based on the users choice
        $this->stubName = 'controllers/' . $stub . '.stub';

        $basecontroller = 'Controller';

        // name of the model (singular and plural)
        $model = $this->containerName;
        $models = Pluralizer::plural($model);

        $entity = Str::lower($model);
        $entities = Pluralizer::plural($entity);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
//                'user-interface' => Str::upper($ui),
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
//                'user-interface' => Str::upper($ui),
                'base-controller' => $basecontroller,

                'model' => $model,
                'models' => $models,
                'entity' => $entity,
                'entities' => $entities,
                'store-request' => $arrRequests['store'] ?? '',
                'update-request' => $arrRequests['update'] ?? '',
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName()
    {
        return 'Controller';
    }
}
