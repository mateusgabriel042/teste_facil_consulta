<?php

namespace App\Http\Resources\Doctor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Location\CityResource;
use App\Enums\DateFormatType;

class DoctorResource extends JsonResource
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
            'especialidade' => $this->especialidade,
            'cidade_id' => $this->cidade_id,
            'cidade' => new CityResource($this->whenLoaded('cidade')),
            'created_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->created_at),
            'updated_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->updated_at),
            'deleted_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->deleted_at),
        ];
    }
}
