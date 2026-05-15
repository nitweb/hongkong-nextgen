<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SiteSettingsController extends Controller
{
    public function SiteSettings()
    {
        $site_settings_info = SiteSettings::first();
        return view('backend.settings.site_settings', compact('site_settings_info'));
    }

    public function SiteSettingsUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_header_logo' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp',
            'site_footer_logo' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,image/gif,image/svg+xml,image/webp',
            'site_address'     => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_copyright'   => 'required|string|max:255',
            'site_google_map'  => 'nullable|string',

            'person1_name'     => 'nullable|string|max:100',
            'person1_email'    => 'nullable|email|max:255',
            'person1_phone'    => 'nullable|string|max:50',

            'person2_name'     => 'nullable|string|max:100',
            'person2_email'    => 'nullable|email|max:255',
            'person2_phone'    => 'nullable|string|max:50',

            'person3_name'     => 'nullable|string|max:100',
            'person3_email'    => 'nullable|email|max:255',
            'person3_phone'    => 'nullable|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $site_settings = SiteSettings::firstOrFail();

            // Header logo
            if ($request->hasFile('site_header_logo')) {
                $old = public_path($site_settings->site_header_logo);
                if ($site_settings->site_header_logo && file_exists($old)) @unlink($old);

                $file      = $request->file('site_header_logo');
                $manager   = new ImageManager(new Driver());
                $file_name = uniqid('header_', true) . '.' . $file->getClientOriginalExtension();
                $manager->read($file->getRealPath())->save(public_path('upload/site_settings/') . $file_name);
                $site_settings->site_header_logo = 'upload/site_settings/' . $file_name;
            }

            // Footer logo
            if ($request->hasFile('site_footer_logo')) {
                $old = public_path($site_settings->site_footer_logo);
                if ($site_settings->site_footer_logo && file_exists($old)) @unlink($old);

                $file      = $request->file('site_footer_logo');
                $manager   = new ImageManager(new Driver());
                $file_name = uniqid('footer_', true) . '.' . $file->getClientOriginalExtension();
                $manager->read($file->getRealPath())->save(public_path('upload/site_settings/') . $file_name);
                $site_settings->site_footer_logo = 'upload/site_settings/' . $file_name;
            }

            // General
            $site_settings->site_address     = $request->site_address;
            $site_settings->site_description = $request->site_description;
            $site_settings->site_copyright   = $request->site_copyright;
            $site_settings->site_google_map  = $request->site_google_map;

            // Persons
            $site_settings->person1_name  = $request->person1_name  ?: null;
            $site_settings->person1_email = $request->person1_email ?: null;
            $site_settings->person1_phone = $request->person1_phone ?: null;

            $site_settings->person2_name  = $request->person2_name  ?: null;
            $site_settings->person2_email = $request->person2_email ?: null;
            $site_settings->person2_phone = $request->person2_phone ?: null;

            $site_settings->person3_name  = $request->person3_name  ?: null;
            $site_settings->person3_email = $request->person3_email ?: null;
            $site_settings->person3_phone = $request->person3_phone ?: null;

            $site_settings->save();

            DB::commit();

            return redirect()->back()->with([
                'message'    => 'Site settings updated successfully!',
                'alert-type' => 'success',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Site Settings update error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with([
                'message'    => 'Failed to update site settings.',
                'alert-type' => 'error',
            ]);
        }
    }
}
