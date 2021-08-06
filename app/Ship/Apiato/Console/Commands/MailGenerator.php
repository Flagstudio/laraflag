<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MailGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:mail';

    protected $description = 'Create a new Mail class';

    protected string $fileType = 'Mail';

    protected string $pathStructure = '{container-name}/Mails/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'mail.stub';

    public array $inputs = [
        ['view', null, InputOption::VALUE_OPTIONAL, 'The name of the view (blade template) to be loaded.'],
    ];

    public function getUserInputs(): array
    {
        $view = $this->checkParameterOrAsk('view', 'Enter the name of the view to be loaded when sending this Mail');

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name'  => $this->containerName,
                'class-name'      => $this->fileName,
                'view'            => $view,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'DefaultMail';
    }
}
