<?php

namespace App\Repositories\Consultation;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Contracts\Consultation\ConsultationRepository;
use App\Models\Consultation\Consultation;
use App\Validators\Consultation\ConsultationValidator;

/**
 * Class ConsultationRepositoryEloquent.
 *
 * @package namespace App\Repositories\Consultation;
 */
class ConsultationRepositoryEloquent extends BaseRepository implements ConsultationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Consultation::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
