<?php

namespace App\Models\Patient;

use App\Models\Consultation\Consultation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Patient.
 *
 * @package namespace App\Models\Patient;
 */
class Patient extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasFactory;

    protected $table = 'pacientes';

    protected $fillable = [
        'id',
        'nome',
        'cpf',
        'celular',
    ];

    public function consultas()
    {
        return $this->hasMany(Consultation::class, 'paciente_id');
    }
}
