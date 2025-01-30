<?php

namespace App\Models\Location;

use App\Models\Doctor\Doctor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class City.
 *
 * @package namespace App\Models\Location;
 */
class City extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasFactory;

    protected $table = 'cidades';

    protected $fillable = [
        'id',
        'nome',
        'estados',
    ];

    public function medicos()
    {
        return $this->hasMany(Doctor::class, 'cidade_id');
    }
}
