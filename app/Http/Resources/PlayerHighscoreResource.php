<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use App\Models\GameScore;
use App\Models\Game;

class PlayerHighscoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // get players highest score
        return [
            'username' => $this->username,
            'score' => $this->highestScore,
            'timestamp' => $this->created_at,
        ];
    }
}
