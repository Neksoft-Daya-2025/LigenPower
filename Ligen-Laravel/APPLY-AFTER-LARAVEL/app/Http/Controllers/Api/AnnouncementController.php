<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(): JsonResponse
    {
        $path = storage_path('app/announcement.json');
        $default = 'Happy Republic Day 2026! Celebrating 77 Years of Indian Democracy - Unity, Justice & Progress | Jai Hind!';

        if (file_exists($path)) {
            $data = json_decode(file_get_contents($path), true);
            $text = $data['text'] ?? $default;
        } else {
            $text = $default;
        }

        return response()->json(['success' => true, 'text' => $text]);
    }
}
