<?php

namespace App\Http\Resources\Consultation;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Doctor\DoctorResource;
use App\Http\Resources\Patient\PatientResource;
use App\Enums\DateFormatType;

class ConsultationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'data' => $this->data,
            'medico_id' => $this->medico_id,
            'paciente_id' => $this->paciente_id,
            'medico' => new DoctorResource($this->whenLoaded('medico')),
            'paciente' => new PatientResource($this->whenLoaded('paciente')),
            'created_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->created_at),
            'updated_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->updated_at),
            'deleted_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->deleted_at),
        ];
    }
}
