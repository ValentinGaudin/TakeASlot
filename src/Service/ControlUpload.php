<?php

namespace App\Service;

use App\Entity\Activity;

class ControlUpload
{
    public function extensionValidity(Activity $activity): ?string
    {
        if (null !== $activity->getPosterFile()) {
            $mimeType = $activity->getPosterFile()->getMimeType();
        }
        $fileTypes = [
            'image' => ['jpg', 'jpeg', 'png', 'gif'],
            'application' => ['pdf',],
            'video' => ['mp4',],
        ];

        foreach ($fileTypes as $type => $extensionArray) {
            foreach ($extensionArray as $extension) {
                if (isset($mimeType) && $mimeType === "$type/$extension") {
                    return $type === 'application' ? 'pdf' : $type;
                }
            }
        }
        return 'Choose the correct format (Jpg,Jpeg,Png,Gif,Pdf,mp4) !';
    }
}
