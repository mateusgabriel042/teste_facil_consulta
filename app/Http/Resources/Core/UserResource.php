<?php

namespace App\Http\Resources\Core;

use App\Enums\DateFormatType;
use App\Http\Resources\Core\RoleResource;
use App\Http\Resources\Plan\PlanResource;
use App\Http\Resources\ImageUpload\ImageUploadedResource;
use App\Http\Resources\Core\PermissionResource;
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_number' => $this->phone_number,
            'role' => RoleResource::collection($this->whenLoaded('role')),
            'permissions' => PermissionResource::collection($this->whenLoaded('permissions')),
            'plan' => PlanResource::collection($this->whenLoaded('plan')),
            'image_uploaded' => new ImageUploadedResource($this->whenLoaded('imageUploaded')),
            'created_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->created_at),
            'updated_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->updated_at),
            'deleted_at' => fmtTimestampToDiffForHumans(DateFormatType::DATETIME_DEFAULT, $this->deleted_at),
        ];
    }
}
