<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\YoutubeVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class YoutubeVideoController extends Controller
{
    public function List()
    {
        $list = YoutubeVideo::latest()->get();
        return view('backend.youtube_videos.list', compact('list'));
    }

    public function Add()
    {
        return view('backend.youtube_videos.add');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'youtube_url' => 'required|url|max:500',
            'title'       => 'nullable|string|max:255',
            'status'      => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();
            YoutubeVideo::create([
                'title'       => $request->title,
                'youtube_url' => $request->youtube_url,
                'status'      => $request->status,
            ]);
            DB::commit();
            return redirect()->route('backend.youtube_video.list')
                ->with(['message' => 'Video added successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('YoutubeVideo Store: ' . $e->getMessage());
            return back()->withInput()->with(['message' => 'Failed to add.', 'alert-type' => 'error']);
        }
    }

    public function Edit($id)
    {
        $info = YoutubeVideo::findOrFail($id);
        return view('backend.youtube_videos.edit', compact('info'));
    }

    public function Update(Request $request)
    {
        $request->validate([
            'id'          => 'required|exists:youtube_videos,id',
            'youtube_url' => 'required|url|max:500',
            'title'       => 'nullable|string|max:255',
            'status'      => 'required|in:active,inactive',
        ]);

        try {
            DB::beginTransaction();
            $video = YoutubeVideo::findOrFail($request->id);
            $video->update([
                'title'       => $request->title,
                'youtube_url' => $request->youtube_url,
                'status'      => $request->status,
            ]);
            DB::commit();
            return back()->with(['message' => 'Updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('YoutubeVideo Update: ' . $e->getMessage());
            return back()->withInput()->with(['message' => 'Failed to update.', 'alert-type' => 'error']);
        }
    }

    public function Delete($id)
    {
        try {
            YoutubeVideo::findOrFail($id)->delete();
            return back()->with(['message' => 'Deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('YoutubeVideo Delete: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to delete.', 'alert-type' => 'error']);
        }
    }
}
