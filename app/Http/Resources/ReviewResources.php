<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ReviewResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        if(Auth::check()) {
            return parent::toArray($request);
        }
        
        return [
            'name' => strtok($this->name, " "),
            'email' => $this->email,
            'created_at' => $this->created_at->format('m d y h:i a'),
            'rating' => $this->rating,
            'feedback' => $this->feedback,
            'comment' => $this->comment,
            'image' => null
        ];

    }
}
