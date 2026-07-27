<?php
namespace App\Models;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryMe extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'gallery_me';

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gallery',
        'name',
        'created_at',
    ];

    /**
     * Menonaktifkan pengelolaan timestamps otomatis oleh Eloquent.
     * Kolom created_at diisi secara manual saat insert atau otomatis oleh database.
     *
     * @var bool
     */
    public $timestamps = false;
}
