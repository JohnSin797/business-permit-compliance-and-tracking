<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $posts = Announcement::orderByDesc('created_at')->limit(10)->get();
        return response()->json([
            'message' => 'OK',
            'posts' => $posts
        ], 200);
    }

    public function oldPosts($post)
    {
        $posts = Announcement::where('id', '<', $post)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();
        return response()->json([
            'message' => 'OK',
            'posts' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        $post = Announcement::create([
            'message' => $validated['message']
        ]);

        $imagePaths = [];

        if ($request->file('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('posts/images/'.$post->id, 'public'); // Store in 'storage/app/public/images'
                $imagePaths[] = $path;
            }
        }

        if (count($imagePaths) > 0) {
            $post->images = $imagePaths;
            $post->save();
        }

        return response()->json([
            'message' => 'OK',
            'post' => $post
        ], 200);
    }
}
