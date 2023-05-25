<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class AiController extends Controller
{
    /**
     * Return parsed text from the uploaded image.
     */
    public function ocr(UserRequest $request)
    {
        $images = Storage::allFiles('public/ocr');

        Storage::delete($images);

        $imagePath = $request->file('image')->storePublicly('ocr', 'public');

        $fullPath = storage_path('app/public/') . $imagePath;

        $parsedText = (new TesseractOCR($fullPath))
                            ->run();

        $response = [
            'image_path'        => $imagePath,
            'full_path'         => $fullPath,
            'text'              => $parsedText,
        ];

        return $response;
    }
}
