<?php

namespace App\Models;

use App\Helpers\UrlHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getShortUrlAttribute(): string
    {
        $urlParts = array_merge(UrlHelper::getUrlParts($this->original_url), ['ending' => $this->hash]);

        return $this->scheme . $urlParts['host'] . $urlParts['path'] . $urlParts['ending'];
    }
}
