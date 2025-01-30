<?php

namespace App\Models\Consultation;

use App\Models\Doctor\Doctor;
use App\Models\Patient\Patient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Consultation.
 *
 * @package namespace App\Models\Consultation;
 */
class Consultation extends Model implements Transformable
{
    use TransformableTrait;
    use SoftDeletes;
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'id',
        'data',
        'medico_id',
        'paciente_id',
    ];

    public function medico()
    {
        return $this->belongsTo(Doctor::class, 'medico_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Patient::class, 'paciente_id');
    }
}
