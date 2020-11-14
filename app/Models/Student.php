<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use JD\Cloudder\Facades\Cloudder;

class Student extends Model
{
    use HasFactory;

    protected $table = "students";

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'image',
    ];

    public function getCloudinaryUrl($publicId) {
        return Cloudder::secureShow($publicId, [
            'width'     => 200,
            'height'    => 200
        ]);
    }
}
