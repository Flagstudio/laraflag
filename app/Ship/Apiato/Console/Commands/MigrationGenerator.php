<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MigrationGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:migration';

    protected $description = 'Create an "empty" migration file for a Container';

    protected string $fileType = 'Migration';

    protected string $pathStructure = '{container-name}/Domain/Migrations/*';

    protected string $nameStructure = '{date}_{file-name}';

    protected string $stubName = 'migrations/generic.stub';

    public array $inputs = [
        ['tablename', null, InputOption::VALUE_NONE, 'The name for the database table'],
        ['stub', null, InputOption::VALUE_NONE, 'The stub file to load for this generator.'],
    ];

    public function getUserInputs(): ?array
    {
        $tablename = Str::lower($this->checkParameterOrAsk('tablename', 'Enter the name of the database table'));

        $stub = Str::lower(
            $this->checkParameterOrChoice(
                'stub',
                'Select the Stub you want to load',
                ['Generic', 'Create', 'Update'],
                0
            )
        );
        $this->stubName = 'migrations/' . $stub . '.stub';

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => Str::studly($this->fileName),
                'table-name' => $tablename
            ],
            'file-parameters' => [
                'date' => Carbon::now()->format('Y_m_d_His'),
                'file-name' => $this->fileName,
            ],
        ];
    }

    public function getDefaultFileName(): string
    {
        return 'create_' . Str::lower($this->containerName) . '_tables';
    }

    protected function removeSpecialChars($str): string
    {
        return $str;
    }
}
