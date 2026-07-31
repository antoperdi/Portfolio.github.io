<?php
namespace App\Models;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'educations';

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'institution',
        'degree',
        'major',
        'period',
        'url',
    ];

    /**
     * Nonaktifkan pengelolaan timestamps otomatis oleh Eloquent.
     * Tabel database educations hanya memiliki kolom created_at (tanpa updated_at).
     *
     * @var bool
     */
    public $timestamps = false;
}
