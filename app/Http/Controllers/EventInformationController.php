<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventInformation;
use App\Models\Attachment;
use App\Http\Requests\EventInformationRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

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
       $newAttachments = [];
        
        if ($request->hasFile('attachment_name')) {
            $existingAttachments = $eventInformation->attachment()->get();
            foreach ($request->file('attachment_name') as $attachmentFile) {
                $attachment = $this->storeAttachment($attachmentFile, $eventInformation->id);
    
                if ($existingAttachments->isNotEmpty()) {
                    // Jika ada attachment yang sudah ada, perbarui dengan data baru
                    $this->storeAttachment($attachmentFile, $eventInformation->id);
                    #$newAttachments[] = $existingAttachment;
                } else {
                    // Jika tidak ada attachment yang sudah ada, buat attachment baru
                    $eventInformation->attachment()->create([
                        'attachment_name' => $attachment->attachment_name,
                    ]);
                    $newAttachments[] = $attachment;
                }
            }
        }
        
        return $newAttachments;
    }

    private function deleteExcessAttachments($eventInformation, $newAttachments) {
        $existingAttachments = $eventInformation->attachment()->get();
        foreach ($existingAttachments as $attachment) {
            if (!in_array($attachment, $newAttachments)) {
                Storage::delete('public/assets/attachments/' . $attachment->attachment_name);
                $attachment->delete();
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
        $newAttachments = $this->updateAttachments($request, $eventInformation);
    
        // Hapus attachment yang lebih banyak
        $this->deleteExcessAttachments($eventInformation, $newAttachments);

        return response()->json([
            'message' => 'Event Information updated successfully',
            'eventInformation' => $eventInformation->loadMissing('attachment'),
            'status'  => 200
        ]);
    }

    public function destroy($id)
    {
        $destroy = EventInformation::findOrFail($id);
        $destroy->delete();

        return response()->json([
            'message'   => 'Post deleted successfully',
            'status'    => 200
        ]);
    }

}
