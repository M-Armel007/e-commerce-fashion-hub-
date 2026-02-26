<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['numero_commande', 'client_id', 'total', 'statut', 'type_vente'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function generateFacture()
    {
        // Logique de génération de facture
        $facture = [
            'numero' => $this->numero_commande,
            'date' => $this->created_at->format('d/m/Y'),
            'client' => $this->client,
            'articles' => $this->items,
            'total' => $this->total
        ];
        
        return $facture;
    }
}