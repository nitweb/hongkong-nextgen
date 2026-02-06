<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AgeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AgeGroupController extends Controller
{
    public function AgeGroupList()
    {
        $age_group_list = AgeGroup::orderBy('id', 'asc')->get();
        return view('backend.age_groups.list', compact('age_group_list'));
    } // End Method

    public function AgeGroupAdd()
    {
        return view('backend.age_groups.add');
    } // End Method

    public function AgeGroupStore(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Age group name is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $age_group_data = new AgeGroup();
            $age_group_data->name = $request->name;
            $age_group_data->slug = Str::slug($request->slug, '-');
            $age_group_data->save();

            DB::commit();

            return redirect()
                ->route('age_group.list')
                ->with([
                    'message' => 'Age Group created successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error creating Age Group: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to create Age Group.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function AgeGroupEdit($id)
    {
        $age_group_info = AgeGroup::findOrFail($id);
        return view('backend.age_groups.edit', compact('age_group_info'));
    } // End Method

    public function AgeGroupUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|string|max:255',
            ],
            [
                'name.required' => 'Age Group name is required',
            ],
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $age_group_data = AgeGroup::findOrFail($request->id);

            if ($request->filled('name')) {
                $age_group_data->name = $request->name;
            }

            if ($request->filled('slug')) {
                $age_group_data->slug = Str::slug($request->slug, '-');
            }

            $age_group_data->save();

            DB::commit();

            return redirect()
                ->back()
                ->with([
                    'message' => 'Age Group updated successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error updating Age Group: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'message' => 'Failed to update Age Group.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method

    public function AgeGroupDelete($id)
    {
        try {
            DB::beginTransaction();

            $age_group_data = AgeGroup::findOrFail($id);

            $age_group_data->delete();

            DB::commit();

            return redirect()
                ->route('age_group.list')
                ->with([
                    'message' => 'Age Group deleted successfully!',
                    'alert-type' => 'success',
                ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error deleting Age Group: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with([
                    'message' => 'Failed to delete Age Group.',
                    'alert-type' => 'error',
                ]);
        }
    } // End Method
}
