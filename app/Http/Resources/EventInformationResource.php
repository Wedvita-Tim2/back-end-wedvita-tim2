<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EventInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'bride_name' => $this->bride_name,
            'groom_name' => $this->groom_name,
            'bride_mother_name' => $this->bride_mother_name,
            'bride_father_name' => $this->bride_father_name,
            'groom_mother_name' => $this->groom_mother_name,
            'groom_father_name' => $this->groom_father_name,
            'cover_image' => Storage::url('public/assets/cover/' . $this->cover_image),
            'date_event' => $this->date_event,
            'guests' => $this->guests,
            'account_number' => $this->account_number,
            'account_holder_name' => $this->account_holder_name,
            'quotes' => $this->quotes,
            'address' => $this->address,
            'building_name' => $this->building_name,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'maps_url' => $this->maps_url,
            'attachment_name' => $this->attachment->pluck('attachment_name')
                ->map(function ($attachmentName) {
                    return Storage::url('public/assets/attachments/' . $attachmentName);
                }),
        ];
    }
}
