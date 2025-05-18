<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BaseModel extends Model
{
     public static function generateRandomPath(int $length = 15, int $partLength = 5) {
        $randomString = str()->random($length);
        $parts = str_split($randomString, $partLength);
        $path = implode(DIRECTORY_SEPARATOR, $parts) . DIRECTORY_SEPARATOR;

        return $path;
    }

    public static function generatRandomFilename(int $length=15) {
        $randomString = str()->random($length);

        return $randomString;
    }
}
