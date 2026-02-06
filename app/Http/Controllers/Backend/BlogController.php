<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BlogController extends Controller
{
    public function BlogList()
    {
        $blog_list = Blog::latest()->get();
        return view('backend.blog.list', compact('blog_list'));
    } // End Method

    public function BlogAdd()
    {
        $blog_categories = BlogCategories::orderBy('blog_category_name')->get();
        return view('backend.blog.add', compact('blog_categories'));
    } // End Method

    public function BlogStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'blog_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'blog_title' => 'required|string|max:255',
                'blog_slug' => 'required|string|max:255|unique:blogs,blog_slug',
                'blog_short_description' => 'required|string',
                'blog_long_description' => 'required|string',
                'blog_category_id' => 'required|integer|exists:blog_categories,id',
                'blog_tags' => 'nullable|string|max:1000',
                'blog_published_by' => 'integer|exists:users,id',
                'blog_published_date' => 'date',
            ],
            [
                'blog_slug.unique' => 'Blog slug already exists',
                'blog_image.required' => 'Blog image is required',
                'blog_image.image' => 'Blog image must be an image file',
                'blog_title.required' => 'Blog title is required',
                'blog_short_description.required' => 'Short description is required',
                'blog_long_description.required' => 'Long description is required',
                'blog_category_id.required' => 'Blog category is required',
                'blog_category_id.exists' => 'Selected category does not exist',
                'blog_published_by.exists' => 'Selected author does not exist',
                'blog_published_date.date' => 'Published date must be a valid date',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $blog_data = new Blog();
            $blog_data->blog_title = $request->blog_title;
            $blog_data->blog_slug = Str::slug($request->blog_slug, '-');
            $blog_data->blog_short_description = $request->blog_short_description;
            $blog_data->blog_long_description = $request->blog_long_description;
            $blog_data->blog_category_id = $request->blog_category_id;
            $blog_data->blog_published_by = Auth::guard('admin')->id();
            $blog_data->blog_published_date = now();

            // --- START TAG PROCESSING ---
            $tagsToStore = null;
            if ($request->blog_tags) {
                $tagArray = json_decode($request->blog_tags, true);

                if (is_array($tagArray)) {
                    $tagValues = array_column($tagArray, 'value');
                    $tagsToStore = implode(',', $tagValues);
                }
            }
            $blog_data->blog_tags = $tagsToStore;
            // --- END TAG PROCESSING ---

            if ($request->hasFile('blog_image')) {
                $file = $request->file('blog_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('blog_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(1200, 628);
                $img->save(public_path('upload/blog_image/') . $file_name);
                $blog_data->blog_image = $file_name;
            }

            $blog_data->save();

            DB::commit();

            return redirect()
                ->route('backend.blog.list')
                ->with([
                    'message' => 'Blog created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            if (isset($filename) && file_exists(public_path('upload/blog_image/' . $filename))) {
                @unlink(public_path('upload/blog_image/' . $filename));
            }
            DB::rollBack();
            Log::error('Error creating Blog: ' . $e->getMessage() . $e->getLine());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create Blog.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function BlogEdit($id)
    {
        $blog_info = Blog::findOrFail($id);
        $blog_categories = BlogCategories::orderBy('blog_category_name')->get();
        return view('backend.blog.edit', compact('blog_info', 'blog_categories'));
    } // End Method

    public function BlogUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'blog_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'blog_title' => 'required|string|max:255',
                'blog_slug' => 'required|string|max:255|unique:blogs,blog_slug,' . $request->id,
                'blog_short_description' => 'required|string',
                'blog_long_description' => 'required|string',
                'blog_category_id' => 'required|integer|exists:blog_categories,id',
                'blog_tags' => 'nullable|string|max:1000',
            ],
            [
                'blog_slug.unique' => 'Blog slug already exists',
                'blog_image.image' => 'Blog image must be an image file',
                'blog_title.required' => 'Blog title is required',
                'blog_short_description.required' => 'Short description is required',
                'blog_long_description.required' => 'Long description is required',
                'blog_category_id.required' => 'Blog category is required',
                'blog_category_id.exists' => 'Selected category does not exist',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $blog_data = Blog::findOrFail($request->id);

            $blog_data->blog_title = $request->blog_title;
            $blog_data->blog_slug = Str::slug($request->blog_slug, '-');
            $blog_data->blog_short_description = $request->blog_short_description;
            $blog_data->blog_long_description = $request->blog_long_description;
            $blog_data->blog_category_id = $request->blog_category_id;

            // --- START TAG PROCESSING ---
            $tagsToStore = null;
            if ($request->blog_tags) {
                $tagArray = json_decode($request->blog_tags, true);
                if (is_array($tagArray)) {
                    $tagValues = array_column($tagArray, 'value');
                    $tagsToStore = implode(',', $tagValues);
                }
            }
            $blog_data->blog_tags = $tagsToStore;
            // --- END TAG PROCESSING ---

            if ($request->hasFile('blog_image')) {
                $oldImage = public_path('upload/blog_image/' . $blog_data->blog_image);
                if ($blog_data->blog_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('blog_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('blog_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                $img->resize(1200, 628);
                $img->save(public_path('upload/blog_image/') . $file_name);
                $blog_data->blog_image = $file_name;
            }

            $blog_data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Blog updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Blog: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Blog.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function BlogDelete($id)
    {
        try {
            DB::beginTransaction();

            $blog_data = Blog::findOrFail($id);

            if ($blog_data->blog_image) {
                $oldImage = public_path('upload/blog_image/' . $blog_data->blog_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $blog_data->delete();

            DB::commit();

            return redirect()
                ->route('backend.blog.list')
                ->with([
                    'message' => 'Blog deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Blog: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Blog.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
