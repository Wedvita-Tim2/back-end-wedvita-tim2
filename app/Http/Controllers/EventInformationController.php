<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInformation;
use App\Models\Attachment;
use App\Http\Requests\EventInformationRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Resources\EventInformationResource;

class EventInformationController extends Controller
{
    private function storeAttachment($attachmentFile, $eventInformationId) {
        $fileName = $attachmentFile ? Str::random(20) . '.webp' : 'default.webp';
        $webpImageData = $attachmentFile ? Image::make($attachmentFile) : null;

        if ($webpImageData) {
            $webpImageData->encode('webp');
            $webpImageData->resize(200, 250);
            Storage::put('public/assets/attachments/' . $fileName, (string) $webpImageData);
        }

        return new Attachment([
            'attachment_name' => $fileName,
            'event_information_id' => $eventInformationId,
        ]);
    }

    private function updateAttachments($request, $eventInformation) {
        // Mendapatkan daftar attachment yang ada
        $existingAttachments = $eventInformation->attachment;
    
        if ($request->hasFile('attachment_name')) {
            foreach ($request->file('attachment_name') as $attachmentFile) {
                if ($existingAttachments->isNotEmpty()) {
                    $existingAttachment = $existingAttachments->shift();
                    if ($existingAttachment->attachment_name !== 'default.webp') {
                        Storage::delete('public/assets/attachments/' .$existingAttachment->attachment_name);
                        $existingAttachment->delete();
                    }
                }
    
                $attachment = $this->storeAttachment($attachmentFile, $eventInformation->id);
                $eventInformation->attachment()->create([
                    'attachment_name' => $attachment->attachment_name,
                ]);
            }
        }
    }

    public function update(EventInformationRequest $request, $id)
    {
        //Check Event Information
        $eventInformation = EventInformation::find($id);
        if (!$eventInformation) {
            return response()->json([
                'message' => 'Event Information not found',
                'status' => 404
            ]);
        }

        //Save cover_image
        $coverName = $eventInformation->cover_image != 'default.webp'
            ? ( $request->hasFile('cover_image')
                    ? Str::random(20) . '.webp'
                    : $eventInformation->cover_image )
            : 'default.webp';

        if ($request->hasFile('cover_image')) {
            $webpImageData = Image::make($request->cover_image);
            $webpImageData->encode('webp');
            $webpImageData->resize(200, 250);

            Storage::put('public/assets/cover/' . $coverName, (string) $webpImageData);

            Storage::delete('public/assets/cover/' . $eventInformation->cover_image);
        }

        //Update Event Information
        $validatedData = $request->validated();
        $validatedData['cover_image'] = $coverName;
        $eventInformation->update($validatedData);

        // Update atau tambahkan attachment
        $this->updateAttachments($request, $eventInformation);

        $eventInformation->refresh();
        $resource = new EventInformationResource($eventInformation);

        return response()->json([
            'message' => 'Event Information updated successfully',
            'eventInformation' => $resource,
            'status'  => 200
        ]);
    }

}
