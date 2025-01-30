<?php

namespace App\Http\Resources\Patient;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\DateFormatType;
use App\Http\Resources\Consultation\ConsultationResource;

class PatientResource extends JsonResource
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
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'celular' => $this->celular,
            'consultas' => ConsultationResource::collection($this->whenLoaded('consultas')),
            'created_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->created_at),
            'updated_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->updated_at),
            'deleted_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->deleted_at),
        ];
    }
}
