<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes'; // Nombre de la tabla
    protected $fillable = ['nombre']; // Campos que se pueden asignar masivamente

    public function articulos()
    {
        return $this->hasMany(Articulos::class);
    }

}
