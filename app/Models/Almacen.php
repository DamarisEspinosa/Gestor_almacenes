<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes'; // Nombre de la tabla
    protected $fillable = ['nombre', 'user_id']; // Campos que se pueden asignar masivamente

    /**
     * Relación con el modelo Articulos
     */
    public function articulos()
    {
        return $this->hasMany(Articulos::class);
    }

    /**
     * Relación con el modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
