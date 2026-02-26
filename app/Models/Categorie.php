<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'slug', 'type', 'genre'];

    public function products()
    {
        return $this->hasMany(Product::class, 'categorie_id');
    }
}