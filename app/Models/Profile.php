<?php
namespace App\Models;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'profile';

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'title',
        'bio',
        'email',
        'phone',
        'address',
        'profile_pic',
        'hero_image_blob',
        'hero_image_mime',
        'about_image_blob',
        'about_image_mime',
        'primary_color',
        'secondary_color',
        'accent_color',
    ];

    /**
     * Menonaktifkan pengelolaan timestamps otomatis oleh Eloquent.
     * MySQL otomatis menangani updated_at menggunakan pemicu (trigger).
     *
     * @var bool
     */
    public $timestamps = false;
}
