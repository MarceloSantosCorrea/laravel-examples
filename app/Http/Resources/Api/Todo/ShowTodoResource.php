<?php

namespace App\Http\Resources\Api\Todo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowTodoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'body' => $this->resource->body,
            'checked' => $this->resource->checked,
            'created_at' => (string)$this->resource->created_at,
            'updated_at' => (string)$this->resource->updated_at,
        ];
    }
}
