<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;

class ContainerGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:container';

    protected $description = 'Create a Container for apiato from scratch';

    protected string $fileType = 'Container';

    protected string $pathStructure = '{container-name}/*';

    protected array $inputs = [];

    public function handle(): int
    {
        $this->validateGenerator($this);

        $this->containerName = ucfirst($this->checkParameterOrAsk('container', 'Enter the name of the Container'));

        // now fix the container and file name
        $this->containerName = $this->removeSpecialChars($this->containerName);
        $this->fileName = $this->removeSpecialChars($this->fileName);

        // and we are ready to start
        $this->printStartedMessage($this->containerName, $this->fileName);

        // get user inputs
        $this->userData = $this->getUserInputs();

        // exit the command successfully
        return 0;
    }

    public function getUserInputs(): array
    {
        // containername as inputted and lower
        $containerName = $this->containerName;
        $_containerName = Str::lower($this->containerName);

        $this->printInfoMessage('Generating Configuration File');
        $this->call('flag:config', [
            '--container'   => $containerName,
            '--file'        => $_containerName,
        ]);

        return [
            'path-parameters' => [
                'container-name' => $containerName,
            ],
            'stub-parameters' => [
                '_container-name' => $_containerName,
                'container-name' => $containerName,
                'class-name' => $this->fileName,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'composer';
    }

    public function getDefaultFileExtension(): string
    {
        return 'json';
    }
}
