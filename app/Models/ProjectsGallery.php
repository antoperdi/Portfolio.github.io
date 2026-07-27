<?php
namespace App\Models;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectsGallery extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'projects_gallery';

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
     * Kolom created_at diisi secara otomatis oleh database MySQL.
     *
     * @var bool
     */
    public $timestamps = false;
}
