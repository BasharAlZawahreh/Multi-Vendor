<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' =>[
                'price' => $this->price,
                'compare_price' => $this->compare_price,
            ],
            'image' => $this->image_url,
            'status' => $this->status,
            'relations'=>[
                'category' =>[
                    'id' => $this->category->id,
                    'name'=> $this->category->name,
                ],
                'store' =>[
                    'id' => $this->store->id,
                    'name'=> $this->store->name,
                ],
            ],
            'tags' => $this->tags->pluck('name'),
        ];
    }

    
}
