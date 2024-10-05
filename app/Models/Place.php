<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Place extends Model
{
    // use HasFactory;
    // protected $fillable = [];
    protected $guarded = [];

    public function getImageAsset()
    {
        if ($this->image) {
            // return asset('storage/'.$this->image);
            return url('').Storage::url($this->image);
        }
        return 'https://placehold.co/150x200?text=No+Image';
    }
}
