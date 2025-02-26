<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserGroup extends Model
{

    use SoftDeletes;

    protected $table = "user_group";
    protected $arraySettings = null;

    public function getListAksesRuang()
    {
        return $this->setting('list_akses_ruang') ?: [];
    }

    public function setting($key, $value = null)
    {
        $args = func_get_args();
        if (is_null($this->arraySettings)) {
            $this->arraySettings = json_decode($this->settings, true) ?: [];
        }

        if (count($args) === 1 && is_string($key)) {
            return array_get($this->arraySettings, $key);
        } elseif (is_array($key)) {
            $arrDots = array_dot($key);
            foreach ($arrDots as $key => $value) {
                array_set($this->arraySettings, $key, $value);
            }
            $this->saveSettings($this->arraySettings);
        } else {
            array_set($this->arraySettings, $key, $value);
            $this->saveSettings($this->arraySettings);
        }
    }

    protected function saveSettings(array $settings)
    {
        $this->settings = json_encode($settings);
        return $this->save();
    }

}
