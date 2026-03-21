<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'make:module
                            {name}
                            {--prefix=Api}
                            {--crud}
                            {--tests}
                            {--factory}
                            {--seeder}';

    protected $description = 'Generate full modular structure';

    public function handle()
    {
        $name = ucfirst($this->argument('name'));
        $prefix = $this->option('prefix');

        $crud = $this->option('crud');
        $tests = $this->option('tests');
        $factory = $this->option('factory');
        $seeder = $this->option('seeder');

        $this->info("Creating module: $name");

        /*
        |--------------------------------------------------------------------------
        | MODEL + MIGRATION
        |--------------------------------------------------------------------------
        */

        $this->call('make:model', [
            'name' => $name,
            '-m' => true
        ]);

        /*
        |--------------------------------------------------------------------------
        | CONTROLLER
        |--------------------------------------------------------------------------
        */

        $this->call('make:controller', [
            'name' => "{$prefix}/{$name}Controller",
            '--api' => true
        ]);

        /*
        |--------------------------------------------------------------------------
        | REQUESTS
        |--------------------------------------------------------------------------
        */

        $this->call('make:request', [
            'name' => "{$name}/Store{$name}Request"
        ]);

        $this->call('make:request', [
            'name' => "{$name}/Update{$name}Request"
        ]);

        /*
        |--------------------------------------------------------------------------
        | RESOURCE
        |--------------------------------------------------------------------------
        */

        $this->createResource($name);

        /*
        |--------------------------------------------------------------------------
        | POLICY
        |--------------------------------------------------------------------------
        */

        $this->createPolicy($name);

        /*
        |--------------------------------------------------------------------------
        | SERVICE
        |--------------------------------------------------------------------------
        */

        $this->createService($name, $crud);

        /*
        |--------------------------------------------------------------------------
        | REPOSITORY
        |--------------------------------------------------------------------------
        */

        $this->createRepository($name, $crud);

        $this->createRepositoryInterface($name);

        /*
        |--------------------------------------------------------------------------
        | DTO
        |--------------------------------------------------------------------------
        */

        $this->createDTO($name);

        /*
        |--------------------------------------------------------------------------
        | ROUTES
        |--------------------------------------------------------------------------
        */

        $this->createRoute($name, $prefix);

        /*
        |--------------------------------------------------------------------------
        | FACTORY
        |--------------------------------------------------------------------------
        */

        if ($factory) {

            $this->call('make:factory', [
                'name' => "{$name}Factory",
                '--model' => $name
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | SEEDER
        |--------------------------------------------------------------------------
        */

        if ($seeder) {

            $this->call('make:seeder', [
                'name' => "{$name}Seeder"
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | TESTS
        |--------------------------------------------------------------------------
        */

        if ($tests) {

            $this->call('make:test', [
                'name' => "{$name}Test"
            ]);
        }

        $this->info("Module $name created successfully 🚀");
    }

    /*
    |--------------------------------------------------------------------------
    | SERVICE
    |--------------------------------------------------------------------------
    */

    private function createService($name, $crud)
    {
        $path = app_path("Services/$name");

        File::ensureDirectoryExists($path);

        $methods = '';

        if ($crud) {

            $methods = "

    public function index()
    {
        return app({$name}Repository::class)->all();
    }

    public function show(\$id)
    {
        return app({$name}Repository::class)->find(\$id);
    }

    public function store(\$data)
    {
        return app({$name}Repository::class)->create(\$data);
    }

    public function update(\$id, \$data)
    {
        return app({$name}Repository::class)->update(\$id, \$data);
    }

    public function destroy(\$id)
    {
        return app({$name}Repository::class)->delete(\$id);
    }
";
        }

        File::put("$path/{$name}Service.php", "<?php

        namespace App\Services\\$name;

        use App\Repositories\\$name\\{$name}Repository;

            class {$name}Service
            {
                $methods
            }
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | REPOSITORY
    |--------------------------------------------------------------------------
    */

    private function createRepository($name, $crud)
    {
        $path = app_path("Repositories/$name");

        File::ensureDirectoryExists($path);

        $methods = '';

        if ($crud) {

            $methods = "

    public function all()
    {
        return {$name}::all();
    }

    public function find(\$id)
    {
        return {$name}::findOrFail(\$id);
    }

    public function create(array \$data)
    {
        return {$name}::create(\$data);
    }

    public function update(\$id, array \$data)
    {
        \$model = {$name}::findOrFail(\$id);
        \$model->update(\$data);
        return \$model;
    }

    public function delete(\$id)
    {
        return {$name}::destroy(\$id);
    }
";
        }

        File::put("$path/{$name}Repository.php", "<?php

            namespace App\Repositories\\$name;

            use App\Models\\$name;
            use App\Repositories\\$name\Contracts\\{$name}RepositoryInterface;

            class {$name}Repository implements {$name}RepositoryInterface
            {
                $methods
            }
        ");
    }

    private function createRepositoryInterface($name)
    {
        $path = app_path("Repositories/$name");

        File::ensureDirectoryExists($path);

        File::put("$path/{$name}RepositoryInterface.php", "<?php

            namespace App\Repositories\\$name;

            interface {$name}RepositoryInterface
            {

            }
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | DTO
    |--------------------------------------------------------------------------
    */

    private function createDTO($name)
    {
        $path = app_path("Dto/$name");

        File::ensureDirectoryExists($path);

        File::put("$path/{$name}Dto.php", "<?php

            namespace App\Dto\\$name;

            class {$name}Dto
            {

            }
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | POLICY
    |--------------------------------------------------------------------------
    */

    private function createPolicy($name)
    {
        $path = app_path("Policies/$name");

        File::ensureDirectoryExists($path);

        File::put("$path/{$name}Policy.php", "<?php

            namespace App\Policies\\$name;

            class {$name}Policy
            {

            }
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | RESOURCE
    |--------------------------------------------------------------------------
    */

    private function createResource($name)
    {
        $path = app_path("Http/Resources/$name");

        File::ensureDirectoryExists($path);

        File::put("$path/{$name}Resource.php", "<?php

            namespace App\Http\Resources\\$name;

            use Illuminate\Http\Resources\Json\JsonResource;

            class {$name}Resource extends JsonResource
            {
                public function toArray(\$request)
                {
                    return parent::toArray(\$request);
                }
            }
        ");
    }

    /*
    |--------------------------------------------------------------------------
    | ROUTES
    |--------------------------------------------------------------------------
    */

    private function createRoute($name, $prefix)
{
    $module = Str::lower($name);
    $route = Str::plural($module);

    // diretório routes/product
    $dir = base_path("routes/$module");

    File::ensureDirectoryExists($dir);

    $controller = "App\Http\Controllers\\$prefix\\{$name}Controller";

    $file = "$dir/$module.php";

    File::put($file, "<?php

        use Illuminate\Support\Facades\Route;
        use $controller;

        Route::apiResource('$route', {$name}Controller::class);
    ");

        $apiFile = base_path('routes/api.php');

        $require = "require __DIR__.'/$module/$module.php';";

        if (!str_contains(File::get($apiFile), $require)) {

            File::append(
                $apiFile,
                "\n$require\n"
            );
        }
    }

}
