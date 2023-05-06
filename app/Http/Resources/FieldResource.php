<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->resource->id,
            'data_type'  => $this->resource->data_type,
            'label'      => $this->resource->label,
            'slug'       => $this->resource->slug,
            'element'    => $this->whenLoaded($this->resource->element),
            'validation' => $this->resource->validation,
            'values'     => $this->resource->values ?? [],
        ];
    }
}
