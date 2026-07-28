<?php

namespace App\Models;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Model;

class ProjectSaya extends Model
{
    /**
     * Nama tabel database yang dihubungkan dengan model ini.
     *
     * @var string
     */
    protected $table = 'Project_Saya';

    /**
     * Kolom-kolom yang dapat diisi secara massal (mass assignable).
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'image_path',
        'caption',
        'Work_Story',
        'Main_Features',
        'Kategori',
        'Tanggal_Proyek',
        'Role',
        'Teknologi',
        'url_code',
        'url_demo',
    ];
}
