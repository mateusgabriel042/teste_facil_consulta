<?php

namespace App\Http\Resources\Core;

use App\Enums\DateFormatType;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->created_at),
            'updated_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->updated_at),
            'deleted_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->deleted_at),
        ];
    }
}
