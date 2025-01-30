<?php

namespace App\Http\Resources\Location;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Enums\DateFormatType;

class CityResource extends JsonResource
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
            'estado' => $this->estado,
            'created_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->created_at),
            'updated_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->updated_at),
            'deleted_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->deleted_at),
        ];
    }
}
