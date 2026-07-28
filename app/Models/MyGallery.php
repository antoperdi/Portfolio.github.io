<?php
namespace App\Models;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyGallery extends Model
{
    use HasFactory;

    // Menyebutkan nama tabel di database secara eksplisit
    protected $table = 'my_galleries';

    // Kolom yang diizinkan untuk diisi data (Mass Assignment)
    protected $fillable = [
        'title',
        'image_path',
        'caption',
        'is_active',
        'is_background',
    ];
}
