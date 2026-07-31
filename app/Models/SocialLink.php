<?php
namespace App\Models;

defined('BASEPATH') OR exit('No direct script access allowed');

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'social_links';

    /**
     * Kolom yang dapat diisi secara massal (mass assignment).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url',
        'icon_path',
        'order_num',
    ];
}
