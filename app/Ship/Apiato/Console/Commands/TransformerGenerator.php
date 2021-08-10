<?php

namespace App\Ship\Apiato\Console\Commands;

use App\Ship\Apiato\Console\GeneratorCommand;
use App\Ship\Apiato\Console\Interfaces\ComponentsGenerator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class TransformerGenerator extends GeneratorCommand implements ComponentsGenerator
{
    protected $name = 'flag:transformer';

    protected $description = 'Create a new Transformer class for a given Model';

    protected string $fileType = 'Transformer';

    protected string $pathStructure = '{container-name}/Transfers/Transformers/*';

    protected string $nameStructure = '{file-name}';

    protected string $stubName = 'transformer.stub';

    public array $inputs = [
        ['model', null, InputOption::VALUE_OPTIONAL, 'The model to generate this Transformer for'],
        ['full', null, InputOption::VALUE_OPTIONAL, 'Generate a Transformer with all fields of the model'],
    ];

    public function getUserInputs(): array
    {
        $model = $this->checkParameterOrAsk('model', 'Enter the name of the Model to generate this Transformer for');
        $full = $this->checkParameterOrConfirm('full', 'Generate a Transformer with all fields', false);

        $attributes = $this->getListOfAllAttributes($full, $model);

        return [
            'path-parameters' => [
                'container-name' => $this->containerName,
            ],
            'stub-parameters' => [
                '_container-name' => Str::lower($this->containerName),
                'container-name' => $this->containerName,
                'class-name' => $this->fileName,
                'model' => $model,
                'attributes' => $attributes,
            ],
            'file-parameters' => [
                'file-name' => $this->fileName,
            ],
        ];
    }

    private function getListOfAllAttributes($full, $model): string
    {
        $indent = str_repeat(' ', 12);
        $fields = [
            'object' => "'$model'",
        ];

        if ($full) {
            $obj = 'App\\Containers\\' . $this->containerName . '\\Data\\Models\\' . $model;
            $obj = new $obj();
            $columns = Schema::getColumnListing($obj->getTable());

            foreach ($columns as $column) {
                if (in_array($column, $obj->getHidden())) {
                    // skip all hidden fields of respective model
                    continue;
                }

                $fields[$column] = '$entity->' . $column;
            }
        }

        $fields = array_merge($fields, [
            'id' => '$entity->getHashedKey()',
            'created_at' => '$entity->created_at',
            'updated_at' => '$entity->updated_at'
        ]);

        $attributes = "";
        foreach ($fields as $key => $value) {
            $attributes = $attributes . $indent . "'$key' => $value," . PHP_EOL;
        }

        return $attributes;
    }
}
