<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class EventGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:event';

    protected $description = 'Create a new Event class and its corresponding Handler';

    protected string $fileType = 'Event';

    protected string $pathStructure = '{container-name}/Events/Events/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'events/event.stub';

    public array $inputs = [
        ['model', null, InputOption::VALUE_OPTIONAL, 'The model to generate this Event for'],
        ['handler', null, InputOption::VALUE_OPTIONAL, 'Generate a Handler for this Event?'],
    ];

    public function getUserInputs(): array
    {
        $model = $this->checkParameterOrAsk('model', 'Enter the name of the Model to generate this Event for');

        $handler = $this->checkParameterOrConfirm('handler', 'Do you want to generate a Handler for this Event?', true);
        if ($handler) {
            // we need to generate a corresponding handler
            // so call the other command
            $status = $this->call('flag:generate:eventhandler', [
                '--container' => $this->containerName,
                '--file' => $this->fileName . 'Handler',
                '--event' => $this->fileName
            ]);

            if ($status == 0) {
                $this->printInfoMessage('The Handler for Event was successfully generated');
            } else {
                $this->printErrorMessage('Could not generate the corresponding Handler!');
            }
        }

        $this->printInfoMessage('!!! Do not forget to register the Event and/or EventHandler !!!');

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'model' => $model,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
