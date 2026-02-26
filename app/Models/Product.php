<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'description', 'prix', 'stock', 
        'categorie_id', 'image', 'taille', 'couleur'
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}