<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;

class GraphQL extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graph:create {entity} {--lists} {--mutations}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a GraphQL object from an Eloquent Object';


    protected $ucfSingular;
    protected $ucfPlural;
    protected $lcfSingular;
    protected $lcfPlural;
    protected $lists;
    protected $mutations;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //Find and replace filenames
        //ss='Location'; sp='Locations'; rs='Example'; rp='Examples'; for f in $(find . -type f); do if [[ $f =~ ^.*("$ss"|"$sp").*$ ]]; then t=$(sed "s/$sp/$rp/g" <<< $f); n=$(sed "s/$ss/$rs/g" <<< $t);  mv $f $n; fi done
        //Find And replace content
        //ss='Location'; sp='Locations'; rs='Example'; rp='Examples'; for f in $(find . -type f); do sed "s/$sp/$rp/g" $f > "$f-temp"; sed "s/$ss/$rs/g" "$f"-temp > $f; rm "$f"-temp; done
        //ss='location'; sp='locations'; rs='example'; rp='examples'; for f in $(find . -type f); do sed "s/$sp/$rp/g" $f > "$f-temp"; sed "s/$ss/$rs/g" "$f"-temp > $f; rm "$f"-temp; done
        //s='Location'; r='Area'; find . -type f -exec sed "s/$s/$r/g" {} +
        //s='Location'; r='Area'; grep -rl . | xargs sed -i ""
        // var_dump($this->argument('entity'));
        // var_dump($this->option('lists'));
        // var_dump($this->option('mutations'));
        $entity = $this->argument('entity');
        $modelsDir = dirname(dirname(dirname(__FILE__)));
        $files = scandir($modelsDir);
        $isValid = false;
        foreach ($files as $file) {
            if ($file == $entity.'.php') {
                $isValid = true;
            }
        }
        // if (!$isValid) {
        //     throw new \Exception("Please use a valid Eloquent Object");
        // }

        $this->ucfSingular = ucfirst(str_singular($entity));
        $this->ucfPlural = ucfirst(str_plural($entity));
        $this->lcfSingular = lcfirst(str_singular($entity));
        $this->lcfPlural = lcfirst(str_plural($entity));
        // echo $this->ucfSingular."\n";
        // echo $this->ucfPlural."\n";
        // echo $this->lcfSingular."\n";
        // echo $this->lcfPlural."\n";
        $this->buildSchema();

    }

    private function buildSchema()
    {
        if (($types = $this->getTypeFiles()) !== false) {
            $this->copyFiles($types);
        }
        if (($queries = $this->getQueryFiles()) !== false) {
            $this->copyFiles($queries);
        }
        if (($mutations = $this->getMutationFiles()) !== false) {
            $this->copyFiles($mutations);
        }
        $modelsDir = dirname(dirname(dirname(__FILE__)));
        $helperEample = $modelsDir."/Console/Commands/GraphQL/entity/ExampleHelper.tpl";
        $finalHelper = $modelsDir."/GraphQL/".$this->ucfSingular."/".$this->ucfSingular."Helper.php";
        $data = $this->readFile($helperEample);
        $data = str_replace('Examples', $this->ucfPlural, $data);
        $data = str_replace('Example', $this->ucfSingular, $data);
        $data = str_replace('examples', $this->lcfPlural, $data);
        $data = str_replace('example', $this->lcfSingular, $data);
        $this->writeFile($data, $finalHelper);
        $finalExporter = $modelsDir."/GraphQL/".$this->ucfSingular."/".$this->ucfSingular."Exporter.php";
        $data = $this->getExporter();
        $this->writeFile($data, $finalExporter);

    }

    private function getExporter()
    {
        $template = (Object)[
            'types' => ["App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."Type"],
            'queries' => [],
            'mutations' => [],
        ];
        if ($this->option('lists')) {
            $template->types[] = "App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."ListDirectionEnumType";
            $template->types[] = "App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."ListFiltersType";
            $template->types[] = "App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."ListOrderEnumType";
            $template->types[] = "App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."ListOrderType";
            $template->types[] = "App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."ListType";
            $template->queries[] = "App\GraphQL\\".$this->ucfSingular."\Queries\All".$this->ucfPlural."Query";
            $template->queries[] = "App\GraphQL\\".$this->ucfSingular."\Queries\\".$this->ucfSingular."CountQuery";
            $template->queries[] = "App\GraphQL\\".$this->ucfSingular."\Queries\One".$this->ucfSingular."Query";
        }

        if ($this->option('mutations')) {
            $template->types[] = "App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."AddInputType";
            $template->types[] = "App\GraphQL\\".$this->ucfSingular."\Types\\".$this->ucfSingular."UpdateInputType";
            $template->mutations[] = "App\GraphQL\\".$this->ucfSingular."\Mutations\Add".$this->ucfSingular."Mutation";
            $template->mutations[] = "App\GraphQL\\".$this->ucfSingular."\Mutations\Remove".$this->ucfSingular."Mutation";
            $template->mutations[] = "App\GraphQL\\".$this->ucfSingular."\Mutations\Update".$this->ucfSingular."Mutation";
        }
        $exporter = "<?php\nnamespace App\GraphQL\\".$this->ucfSingular.";\n\nuse App\GraphQL\Exporter;\n\nclass ".$this->ucfSingular."Exporter implements Exporter {\n\n";
        $exporter .= "    static function getTypes()\n    {";
        $exporter .= "\n        return [";
        foreach ($template->types as $type) {
            $exporter .= "\n            '".$type."',";
        }
        $exporter .= "\n        ];\n    }\n\n";
        $exporter .= "    static function getQueries()\n    {";
        $exporter .= "\n        return [";
        foreach ($template->queries as $query) {
            $exporter .= "\n            '".$query."',";
        }
        $exporter .= "\n        ];\n    }\n\n";
        $exporter .= "    static function getMutations()\n    {";
        $exporter .= "\n        return [";
        foreach ($template->mutations as $mutation) {
            $exporter .= "\n            '".$mutation."',";
        }
        $exporter .= "\n        ];\n    }\n\n";
        $exporter .= "}";
        return $exporter;
    }

    private function copyFiles($files)
    {
        $this->makeDiectory($files->requiredDir);
        foreach ($files->files as $file) {
            $data = $this->readFile($file->example);
            $data = str_replace('Examples', $this->ucfPlural, $data);
            $data = str_replace('Example', $this->ucfSingular, $data);
            $data = str_replace('examples', $this->lcfPlural, $data);
            $data = str_replace('example', $this->lcfSingular, $data);
            $this->writeFile($data, $file->destination);
        }
    }

    private function makeDiectory($dir)
    {
        exec("mkdir -p $dir");
    }

    private function readFile($from)
    {
        if (($fs = fopen($from, 'r')) !== false) {
            $data = fread($fs, 204800);
            fclose($fs);
            return $data;
        }
        return false;
    }

    private function writeFile($data, $to)
    {
        if (($fs = fopen($to, 'w')) !== false) {
            fwrite($fs, $data);
            fclose($fs);
            return true;
        }
        return false;
    }

    private function getTypeFiles()
    {
        $modelsDir = dirname(dirname(dirname(__FILE__)));
        $return = (object)[
            "requiredDir" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/",
            "files" => [(object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."Type.php",
            ]],
        ];
        if (!$this->option('lists') && !$this->option('mutations')) {
            $return = (object)[
                "requiredDir" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/",
                "files" => [(object)[
                    "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleTypeDerived.tpl",
                    "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."Type.php",
                ]],
            ];
        }
        if ($this->option('lists')) {
            $return->files[] = (object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleListDirectionEnumType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."ListDirectionEnumType.php",
            ];
            $return->files[] = (object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleListFiltersType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."ListFiltersType.php",
            ];
            $return->files[] = (object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleListOrderEnumType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."ListOrderEnumType.php",
            ];
            $return->files[] = (object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleListOrderType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."ListOrderType.php",
            ];
            $return->files[] = (object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleListType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."ListType.php",
            ];

        }
        if ($this->option('mutations')) {
            $return->files[] = (object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleAddInputType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."AddInputType.php",
            ];
            $return->files[] = (object)[
                "example" => "$modelsDir/Console/Commands/GraphQL/entity/Types/ExampleUpdateInputType.tpl",
                "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Types/".$this->ucfSingular."UpdateInputType.php",
            ];
        }
        return $return;
    }

    private function getQueryFiles()
    {
        $modelsDir = dirname(dirname(dirname(__FILE__)));
        if ($this->option('lists')) {
            return (object)[
                "requiredDir" => $modelsDir."/GraphQL/".$this->ucfSingular."/Queries/",
                "files" => [(object)[
                    "example" => "$modelsDir/Console/Commands/GraphQL/entity/Queries/AllExamplesQuery.tpl",
                    "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Queries/All".$this->ucfPlural."Query.php",
                ], (object)[
                    "example" => "$modelsDir/Console/Commands/GraphQL/entity/Queries/ExampleCountQuery.tpl",
                    "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Queries/".$this->ucfSingular."CountQuery.php",
                ], (object)[
                    "example" => "$modelsDir/Console/Commands/GraphQL/entity/Queries/OneExampleQuery.tpl",
                    "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Queries/One".$this->ucfSingular."Query.php",
                ]],
            ];
        }
        return false;
    }

    private function getMutationFiles()
    {
        $modelsDir = dirname(dirname(dirname(__FILE__)));
        if ($this->option('mutations')) {
            return (object)[
                "requiredDir" => $modelsDir."/GraphQL/".$this->ucfSingular."/Mutations/",
                "files" => [(object)[
                    "example" => "$modelsDir/Console/Commands/GraphQL/entity/Mutations/AddExampleMutation.tpl",
                    "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Mutations/Add".$this->ucfSingular."Mutation.php",
                ], (object)[
                    "example" => "$modelsDir/Console/Commands/GraphQL/entity/Mutations/RemoveExampleMutation.tpl",
                    "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Mutations/Remove".$this->ucfSingular."Mutation.php",
                ], (object)[
                    "example" => "$modelsDir/Console/Commands/GraphQL/entity/Mutations/UpdateExampleMutation.tpl",
                    "destination" => $modelsDir."/GraphQL/".$this->ucfSingular."/Mutations/Update".$this->ucfSingular."Mutation.php",
                ]],
            ];
        }
        return false;
    }

    private function getTestFiles()
    {

    }

    private function copyTests()
    {

    }

    private function replaceTests()
    {

    }

    private function copyEntity()
    {

    }

}
