<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class RouteGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:route';

    protected $description = 'Create a new Route file';

    protected string $fileType = 'Route';

    protected string $pathStructure = '{container-name}/Routes/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'routes/web.stub';

    public array $inputs = [
        ['stub', null, InputOption::VALUE_OPTIONAL, 'The stub file to load for this generator.'],
    ];

    public function handle(): int
    {
        $this->validateGenerator($this);

        $this->containerName = ucfirst($this->checkParameterOrAsk('container', 'Enter the name of the Container'));
        $this->fileName = $this->containerName = $this->removeSpecialChars($this->containerName);

        $this->userData = $this->getUserInputs();

        $this->warn('Generating Route file');
        foreach ($this->userData as $data) {
            $this->parsedFileName = $this->parseFileStructure($this->nameStructure, $data['file-parameters']);
            $filePath = $this->getFilePath($this->parsePathStructure($this->pathStructure, $data['path-parameters']));

            if (! $this->fileSystem->exists($filePath)) {
                $this->stubName = 'routes/' . $data['file-parameters']['stub'] . '.stub';
                // prepare stub content
                $this->stubContent = $this->getStubContent();
                $this->renderedStubContent = $this->parseStubContent($this->stubContent, $data['stub-parameters']);
                $this->generateFile($filePath, $this->renderedStubContent);
                $this->printFinishedMessage($this->fileType);
            }
        }

        // exit the command successfully
        return 0;
    }

    public function getUserInputs(): array
    {
        $stub = Str::lower(
            $this->checkParameterOrChoice(
                'stub',
                'Select the Stub you want to load',
                ['web', 'api', 'all'],
                0
            )
        );

        $stubs = ['api', 'web'];
        if ($stub !== 'all') {
            $stubs = [$stub];
        }

        $files = [];
        foreach ($stubs as $s) {
            $files[] = [
                'path-parameters' => [
                    'container-name' => $this->containerName,
                ],
                'stub-parameters' => [
                    'container-name' => $this->containerName,
                ],
                'file-parameters' => [
                    'file-name' => $s,
                    'stub' => $s,
                ],
            ];
        }

        return $files;
    }
}
