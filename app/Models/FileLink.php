<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileLink extends Model
{
    protected $fillable = [
        'file_id', 'token', 'password', 'is_used'
    ];
    protected $casts = [
        'is_used' => 'boolean'
    ];

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function isValid()
    {
        return !$this->is_used;
    }
}
