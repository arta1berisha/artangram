<?php

namespace App\Http\Resources\Like;

use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LikeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'user';
 
   
}
