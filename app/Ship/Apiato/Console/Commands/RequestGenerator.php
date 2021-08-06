<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class RequestGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:request';

    protected $description = 'Create a new Request class';

    protected string $fileType = 'Request';

    protected string $pathStructure = '{container-name}/Http/Requests/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'request.stub';

    public array $inputs = [
        ['transporter', null, InputOption::VALUE_OPTIONAL, 'Create a corresponding Transporter for this Request'],
        ['transportername', null, InputOption::VALUE_OPTIONAL, 'The name of the Transporter to be assigned'],
    ];

    public function getUserInputs(): array
    {
        $transporter = false;
        if ($transporter) {
            $transporterName = $this->checkParameterOrAsk('transportername', 'Enter the Name of the corresponding Transporter to be assigned');

            $transporterComment = '';
            $transporterClass = '\\App\\Containers\\' . $this->containerName . '\\Data\\Transporters\\' . $transporterName . '::class';

            // now create the Transporter
            $this->call('flag:generate:transporter', [
                '--container' => $this->containerName,
                '--file' => $transporterName,
            ]);
        } else {
            $transporterComment = '// ';
            $transporterClass = '\\App\\Ship\\Transporters\\DataTransporter::class';
        }

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'transporterEnabled' => $transporterComment,
                'transporterClass' => $transporterClass,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }
}
