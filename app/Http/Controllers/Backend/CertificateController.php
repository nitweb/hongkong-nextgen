<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function CertificateList()
    {
        $title = 'Qualification Certificate';
        $certificate_list = Certificate::latest()->get();
        return view('backend.certificate.list', compact('title', 'certificate_list'));
    } // End Method

    public function CertificateAdd()
    {
        $title = 'Qualification Certificate';
        return view('backend.certificate.add', compact('title'));
    } // End Method

    public function CertificateStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'certificate_title' => 'required|string|max:255',
            ],
            [
                'certificate_image.image' => 'Qualification Certificate image must be an image file',
                'certificate_title.required' => 'Qualification Certificate title is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data = new Certificate();
            $data->certificate_title = $request->certificate_title;

            if ($request->hasFile('certificate_image')) {
                $file = $request->file('certificate_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('certificate_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                // $img->resize(216, 308);
                $img->save(public_path('upload/certificate_image/') . $file_name);
                $data->certificate_image = $file_name;
            }

            $data->save();

            DB::commit();

            return redirect()
                ->route('backend.certificate.list')
                ->with([
                    'message' => 'Qualification Certificate created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            if (isset($filename) && file_exists(public_path('upload/certificate_image/' . $filename))) {
                @unlink(public_path('upload/certificate_image/' . $filename));
            }
            DB::rollBack();
            Log::error('Error creating Qualification Certificate: ' . $e->getMessage() . $e->getLine());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create Qualification Certificate.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function CertificateEdit($id)
    {
        $title = 'Qualification Certificate';
        $certificate_info = Certificate::findOrFail($id);
        return view('backend.certificate.edit', compact('title', 'certificate_info'));
    } // End Method

    public function CertificateUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'certificate_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
                'certificate_title' => 'required|string|max:255',
            ],
            [
                'certificate_image.image' => 'Qualification Certificate image must be an image file',
                'certificate_title.required' => 'Qualification Certificate title is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data = Certificate::findOrFail($request->id);
            $data->certificate_title = $request->certificate_title;

            if ($request->hasFile('certificate_image')) {
                $oldImage = public_path('upload/certificate_image/' . $data->certificate_image);
                if ($data->certificate_image && file_exists($oldImage)) {
                    @unlink($oldImage);
                }

                $file = $request->file('certificate_image');
                $manager = new ImageManager(new Driver());
                $file_name = uniqid('certificate_', true) . '.' . $file->getClientOriginalExtension();
                $img = $manager->read($file->getRealPath());
                // $img->resize(216, 308);
                $img->save(public_path('upload/certificate_image/') . $file_name);
                $data->certificate_image = $file_name;
            }

            $data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Qualification Certificate updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Qualification Certificate: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Qualification Certificate.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function CertificateDelete($id)
    {
        try {
            DB::beginTransaction();

            $data = Certificate::findOrFail($id);

            if ($data->certificate_image) {
                $oldImage = public_path('upload/certificate_image/' . $data->certificate_image);
                if (file_exists($oldImage)) {
                    @unlink($oldImage);
                }
            }

            $data->delete();

            DB::commit();

            return redirect()
                ->route('backend.certificate.list')
                ->with([
                    'message' => 'Qualification Certificate deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Qualification Certificate: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Qualification Certificate.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
