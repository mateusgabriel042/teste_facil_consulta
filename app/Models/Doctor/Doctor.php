<?php

namespace App\Models\Doctor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use App\Models\Location\City;
use App\Models\Consultation\Consultation;

/**
 * Class Doctor.
 *
 * @package namespace App\Models\Doctor;
 */
class Doctor extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasFactory;

    protected $table = 'medicos';

    protected $fillable = [
        'id',
        'nome',
        'especialidade',
        'cidade_id',
    ];

    public function cidade()
    {
        return $this->belongsTo(City::class, 'cidade_id');
    }

    public function consultas()
    {
        return $this->hasMany(Consultation::class, 'medico_id');
    }
}
