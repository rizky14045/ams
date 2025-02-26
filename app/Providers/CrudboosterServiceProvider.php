<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use crocodicstudio\crudbooster\CRUDBoosterServiceProvider as BaseCrudboosterServiceProvider;

class CrudboosterServiceProvider extends BaseCrudboosterServiceProvider
{
    public function boot()
    {        
        $cbPath = base_path('vendor/crocodicstudio/crudbooster/src');
        $viewDir = 'views/vendor/crudbooster';
 
        $this->loadViewsFrom(resource_path($viewDir), 'crudbooster');
        $this->publishes([$cbPath.'/configs/crudbooster.php' => config_path('crudbooster.php')],'cb_config');            
        $this->publishes([$cbPath.'/localization' => resource_path('lang')], 'cb_localization');                 
        $this->publishes([$cbPath.'/database' => base_path('database')],'cb_migration');
        $this->publishes([$cbPath.'/views' => resource_path($viewDir)], 'cb_views');

        $this->publishes([
            $cbPath.'/userfiles/views/vendor/crudbooster/type_components/readme.txt' => resource_path('views/vendor/crudbooster/type_components/readme.txt'),
        ],'cb_type_components');

        if(!file_exists(app_path('Http/Controllers/CBHook.php'))) {
            $this->publishes([$cbPath.'/userfiles/controllers/CBHook.php' => app_path('Http/Controllers/CBHook.php')],'CBHook');
        }

        if(!file_exists(app_path('Http/Controllers/AdminCmsUsersController.php'))) {
            $this->publishes([$cbPath.'/userfiles/controllers/AdminCmsUsersController.php' => app_path('Http/Controllers/AdminCmsUsersController.php')],'cb_user_controller');
        }
               
        require $cbPath.'/validations/validation.php';        
        require $cbPath.'/routes.php';                        
    }
}
