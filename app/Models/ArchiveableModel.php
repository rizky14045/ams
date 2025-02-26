<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class ArchiveableModel extends Model
{
    use SoftDeletes;

    public function scopeArchived($query)
    {
        $table = $this->getTable();
        return $query->withTrashed()->whereNotNull($table.'.deleted_at');
    }

    public function withArchived($query)
    {
        return $query->withTrashed();
    }

    public static function findArchive($id)
    {
        $key = (new static)->getKeyName();
        return static::archived()->where($key, $id)->first();
    }

    public static function findArchiveOrFail($id)
    {
        $key = (new static)->getKeyName();
        return static::archived()->where($key, $id)->firstOrFail();
    }

}
