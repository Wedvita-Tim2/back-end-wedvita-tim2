<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderResource extends JsonResource
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
            'order_code' => $this->order_code,
            'order_verification' => $this->order_verification,
            'user_id' => $this->user_id,
            'template_id' => $this->template_id,
            'event_information_id' => $this->event_information_id,
            'username' => $this->user->username,
            'template_name' => $this->template->template_name,
            'bride_name' => $this->eventInformation->bride_name,
            'groom_name' => $this->eventInformation->groom_name,
            'bride_mother_name' => $this->eventInformation->bride_mother_name,
            'bride_father_name' => $this->eventInformation->bride_father_name,
            'groom_mother_name' => $this->eventInformation->groom_mother_name,
            'groom_father_name' => $this->eventInformation->groom_father_name,
            'cover_image' => Storage::url('public/assets/cover/' .   $this->eventInformation->cover_image),
            'date_event' => $this->eventInformation->date_event,
            'guests' => $this->eventInformation->guests,
            'account_number' => $this->eventInformation->account_number,
            'account_holder_name' => $this->eventInformation->account_holder_name,
            'quotes' => $this->eventInformation->quotes,
            'address' => $this->eventInformation->address,
            'building_name' => $this->eventInformation->building_name,
            'lat' => $this->eventInformation->lat,
            'lng' => $this->eventInformation->lng,
            'maps_url' => $this->eventInformation->maps_url,
            'attachment_name' => $this->eventInformation->attachment->pluck('attachment_name')
                ->map(function ($attachmentName) {
                    return Storage::url('public/assets/attachments/' . $attachmentName);
                }),
        ];
    }
}
