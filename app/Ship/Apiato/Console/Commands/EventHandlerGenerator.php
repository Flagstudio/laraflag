<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Symfony\Component\Console\Input\InputOption;

class EventHandlerGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:eventhandler';

    protected $description = 'Create a new EventHandler class';

    protected string $fileType = 'EventHandler';

    protected string $pathStructure = '{container-name}/Events/Handlers/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'events/eventhandler.stub';

    public array $inputs = [
        ['event', null, InputOption::VALUE_OPTIONAL, 'The Event to generate this Handler for'],
    ];

    public function getUserInputs(): array
    {
        $event = $this->checkParameterOrAsk('event', 'Enter the name of the Event to generate this Handler for');

        $this->printInfoMessage('!!! Do not forget to register the Event and/or EventHandler !!!');

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'model' => $event,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
