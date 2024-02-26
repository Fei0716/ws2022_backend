<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class HighscoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   

        return [
            'game' => new AuthoredGameResource($this),
            'score' => $this->highestScore,
            'timestamp' => $this->created_at,
        ];
    }
}
