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

    public function update(EventInformationRequest $request, $id)
    {
        //Check Event Information
        //dd($request);
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

        //Looping & Store attachment
        $attachments = Attachment::where('event_information_id', $eventInformation->id)->get();
        foreach ($request->file('attachment_name') as $attachmentFile) {
            $attachment = $this->storeAttachment($attachmentFile, $eventInformation->id);
            
            if ($attachments->isNotEmpty()) {
                // Jika attachment sudah ada, perbarui dengan data baru
                $attachments->shift()->update([
                    'attachment_name' => $attachment->attachment_name,
                ]);
            } else {
                // Jika tidak ada attachment yang sudah ada, buat attachment baru
                $eventInformation->attachment()->create([
                    'attachment_name' => $attachment->attachment_name,
                ]);
            }
        }

        // Hapus attachment yang lebih banyak
        if ($attachments->isNotEmpty()) {
            $attachments->each(function ($attachment) {
                Storage::delete('public/assets/attachments/' . $attachment->attachment_name);
                $attachment->delete();
            });
        }

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
