<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BatteryAd;
use App\Models\BatteryModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BatteryModuleController extends Controller
{
    /* ===== Module List ===== */
    public function BatteryList()
    {
        try {
            $modules = BatteryModule::latest()->get();
            $ads = BatteryAd::orderBy('sort_order')->get();
            return view('backend.battery.list', compact('modules', 'ads'));
        } catch (\Throwable $e) {
            Log::error('BatteryList Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to load modules.', 'alert-type' => 'error']);
        }
    }

    /* ===== Module Add Form ===== */
    public function BatteryAdd()
    {
        $categories = BatteryModule::whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category');

        return view('backend.battery.add', compact('categories'));
    }

    /* ===== Module Store ===== */
    public function BatteryStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'file_path' => 'required|mimes:xlsx,xls,csv|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Excel file save
            $file = $request->file('file_path');
            $fileName = uniqid('battery_', true) . '.' . $file->getClientOriginalExtension();
            $dir = public_path('upload/battery_modules');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $file->move($dir, $fileName);

            $module = BatteryModule::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'file_path' => 'upload/battery_modules/' . $fileName,
                'status' => $request->status,
            ]);

            // Thumbnail save
            if ($request->hasFile('thumbnail')) {
                $manager = new ImageManager(new Driver());
                $img = $request->file('thumbnail');
                $imgName = uniqid('thumb_', true) . '.' . $img->getClientOriginalExtension();
                $imgDir = public_path('upload/battery_thumbs');
                if (!file_exists($imgDir)) {
                    mkdir($imgDir, 0755, true);
                }
                $manager
                    ->read($img)
                    ->resize(400, 300)
                    ->save($imgDir . '/' . $imgName);
                $module->update(['thumbnail' => 'upload/battery_thumbs/' . $imgName]);
            }

            DB::commit();

            return redirect()
                ->route('backend.battery.list')
                ->with(['message' => 'Battery module added!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BatteryStore Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()
                ->withInput()
                ->with(['message' => 'Failed to add battery module.', 'alert-type' => 'error']);
        }
    }

    /* ===== Module Edit ===== */
    public function BatteryEdit($id)
    {
        try {
            $module = BatteryModule::findOrFail($id);

            $categories = BatteryModule::whereNotNull('category')->where('category', '!=', '')->distinct()->pluck('category');

            return view('backend.battery.edit', compact('module', 'categories'));
        } catch (\Throwable $e) {
            Log::error('BatteryEdit Error: ' . $e->getMessage());
            return back()->with(['message' => 'Module not found.', 'alert-type' => 'error']);
        }
    }

    /* ===== Module Update ===== */
    public function BatteryUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'module_id' => 'required|exists:battery_modules,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'category' => 'nullable|string|max:100',
            'file_path' => 'nullable|mimes:xlsx,xls,csv|max:10240',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $module = BatteryModule::findOrFail($request->module_id);

            $module->update([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'status' => $request->status,
            ]);

            // New Excel file
            if ($request->hasFile('file_path')) {
                @unlink(public_path($module->file_path));
                $file = $request->file('file_path');
                $fileName = uniqid('battery_', true) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('upload/battery_modules'), $fileName);
                $module->update(['file_path' => 'upload/battery_modules/' . $fileName]);
            }

            // New Thumbnail
            if ($request->hasFile('thumbnail')) {
                if ($module->thumbnail) {
                    @unlink(public_path($module->thumbnail));
                }
                $manager = new ImageManager(new Driver());
                $img = $request->file('thumbnail');
                $imgName = uniqid('thumb_', true) . '.' . $img->getClientOriginalExtension();
                $imgDir = public_path('upload/battery_thumbs');
                if (!file_exists($imgDir)) {
                    mkdir($imgDir, 0755, true);
                }
                $manager
                    ->read($img)
                    ->resize(400, 300)
                    ->save($imgDir . '/' . $imgName);
                $module->update(['thumbnail' => 'upload/battery_thumbs/' . $imgName]);
            }

            DB::commit();

            return redirect()
                ->back()
                ->with(['message' => 'Battery module updated!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BatteryUpdate Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()
                ->withInput()
                ->with(['message' => 'Failed to update battery module.', 'alert-type' => 'error']);
        }
    }

    /* ===== Module Delete ===== */
    public function BatteryDelete($id)
    {
        try {
            DB::beginTransaction();

            $module = BatteryModule::findOrFail($id);
            if ($module->file_path) {
                @unlink(public_path($module->file_path));
            }
            if ($module->thumbnail) {
                @unlink(public_path($module->thumbnail));
            }
            $module->delete();

            DB::commit();

            return back()->with(['message' => 'Module deleted!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BatteryDelete Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()->with(['message' => 'Failed to delete module.', 'alert-type' => 'error']);
        }
    }

    /* ===== Ad List ===== */
    public function BatteryAdList()
    {
        try {
            $ads = BatteryAd::orderBy('sort_order')->get();
            return view('backend.battery_ad.list', compact('ads'));
        } catch (\Throwable $e) {
            Log::error('BatteryAdList Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to load ads.', 'alert-type' => 'error']);
        }
    }

    /* ===== Ad Add Form ===== */
    public function BatteryAdAdd()
    {
        return view('backend.battery_ad.add');
    }

    /* ===== Ad Store ===== */
    public function BatteryAdStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,jpeg,png,webp',
            'link' => 'nullable|url|max:500',
            'title' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $manager = new ImageManager(new Driver());
            $img = $request->file('image');
            $imgName = uniqid('ad_', true) . '.' . $img->getClientOriginalExtension();
            $dir = public_path('upload/battery_ads');
            if (!file_exists($dir)) {
                mkdir($dir, 0755, true);
            }
            $manager
                ->read($img)
                ->resize(1200, 400)
                ->save($dir . '/' . $imgName);

            BatteryAd::create([
                'title' => $request->title,
                'image' => 'upload/battery_ads/' . $imgName,
                'link' => $request->link,
                'sort_order' => $request->sort_order ?? 0,
                'status' => 'active',
            ]);

            DB::commit();

            return redirect()
                ->route('backend.battery.ad.list')
                ->with(['message' => 'Ad added!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BatteryAdStore Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()
                ->withInput()
                ->with(['message' => 'Failed to add ad.', 'alert-type' => 'error']);
        }
    }

    /* ===== Ad Edit Form ===== */
    public function BatteryAdEdit($id)
    {
        try {
            $ad = BatteryAd::findOrFail($id);
            return view('backend.battery_ad.edit', compact('ad'));
        } catch (\Throwable $e) {
            Log::error('BatteryAdEdit Error: ' . $e->getMessage());
            return back()->with(['message' => 'Ad not found.', 'alert-type' => 'error']);
        }
    }

    /* ===== Ad Update ===== */
    public function BatteryAdUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ad_id' => 'required|exists:battery_ads,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'link' => 'nullable|url|max:500',
            'title' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $ad = BatteryAd::findOrFail($request->ad_id);

            $ad->update([
                'title' => $request->title,
                'link' => $request->link,
                'sort_order' => $request->sort_order ?? 0,
            ]);

            if ($request->hasFile('image')) {
                @unlink(public_path($ad->image));
                $manager = new ImageManager(new Driver());
                $img = $request->file('image');
                $imgName = uniqid('ad_', true) . '.' . $img->getClientOriginalExtension();
                $dir = public_path('upload/battery_ads');
                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
                $manager
                    ->read($img)
                    ->resize(1200, 400)
                    ->save($dir . '/' . $imgName);
                $ad->update(['image' => 'upload/battery_ads/' . $imgName]);
            }

            DB::commit();

            return back()->with(['message' => 'Ad updated!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BatteryAdUpdate Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()
                ->withInput()
                ->with(['message' => 'Failed to update ad.', 'alert-type' => 'error']);
        }
    }

    /* ===== Ad Delete ===== */
    public function BatteryAdDelete($id)
    {
        try {
            DB::beginTransaction();

            $ad = BatteryAd::findOrFail($id);
            @unlink(public_path($ad->image));
            $ad->delete();

            DB::commit();

            return back()->with(['message' => 'Ad deleted!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('BatteryAdDelete Error: ' . $e->getMessage() . ' | Line: ' . $e->getLine());
            return back()->with(['message' => 'Failed to delete ad.', 'alert-type' => 'error']);
        }
    }

    /* ===== Frontend Page ===== */
    public function frontend()
    {
        try {
            $modules = BatteryModule::where('status', 'active')->latest()->get();
            $ads = BatteryAd::where('status', 'active')->orderBy('sort_order')->get();
            return view('frontend.pages.battery_module', compact('modules', 'ads'));
        } catch (\Throwable $e) {
            Log::error('Battery Frontend Error: ' . $e->getMessage());
            return back()->with(['message' => 'Something went wrong.', 'alert-type' => 'error']);
        }
    }

    /* ===== AJAX Search ===== */
    public function ajaxSearch(Request $request)
    {
        try {
            $query = $request->input('query');
            $modules = BatteryModule::where('status', 'active')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'LIKE', "%{$query}%")
                        ->orWhere('category', 'LIKE', "%{$query}%")
                        ->orWhere('description', 'LIKE', "%{$query}%");
                })
                ->get()
                ->map(function ($m) {
                    $m->file_url = asset($m->file_path);
                    return $m;
                });

            return response()->json(['modules' => $modules]);
        } catch (\Throwable $e) {
            Log::error('BatteryAjaxSearch Error: ' . $e->getMessage());
            return response()->json(['modules' => [], 'error' => 'Search failed.'], 500);
        }
    }
}
