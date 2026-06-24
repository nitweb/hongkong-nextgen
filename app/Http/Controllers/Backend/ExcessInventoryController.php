<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ExcessInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ExcessInventoryController extends Controller
{
    public function List()
    {
        $list = ExcessInventory::latest()->get();
        return view('backend.excess_inventory.list', compact('list'));
    }

    public function Add()
    {
        return view('backend.excess_inventory.add');
    }

    public function Store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'particulars'  => 'required|string|max:255',
            'excel_file'   => 'nullable|mimes:xlsx,xls,csv|max:10240',
            'pdf_file'     => 'nullable|mimes:pdf|max:5120',
            'status'       => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data = new ExcessInventory();
            $data->particulars = $request->particulars;
            $data->status      = $request->status;

            if ($request->hasFile('excel_file')) {
                $dir  = public_path('upload/excess_inventory/excel');
                if (!file_exists($dir)) mkdir($dir, 0755, true);
                $file = $request->file('excel_file');
                $name = uniqid('excel_', true) . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $name);
                $data->excel_file = 'upload/excess_inventory/excel/' . $name;
            }

            if ($request->hasFile('pdf_file')) {
                $dir  = public_path('upload/excess_inventory/pdf');
                if (!file_exists($dir)) mkdir($dir, 0755, true);
                $file = $request->file('pdf_file');
                $name = uniqid('pdf_', true) . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $name);
                $data->pdf_file = 'upload/excess_inventory/pdf/' . $name;
            }

            $data->save();
            DB::commit();

            return redirect()
                ->route('backend.excess_inventory.list')
                ->with(['message' => 'Excess Inventory added successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ExcessInventory Store Error: ' . $e->getMessage());
            return back()->withInput()->with(['message' => 'Failed to add.', 'alert-type' => 'error']);
        }
    }

    public function Edit($id)
    {
        $info = ExcessInventory::findOrFail($id);
        return view('backend.excess_inventory.edit', compact('info'));
    }

    public function Update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'           => 'required|exists:excess_inventories,id',
            'particulars'  => 'required|string|max:255',
            'excel_file'   => 'nullable|mimes:xlsx,xls,csv|max:10240',
            'pdf_file'     => 'nullable|mimes:pdf|max:5120',
            'status'       => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $data              = ExcessInventory::findOrFail($request->id);
            $data->particulars = $request->particulars;
            $data->status      = $request->status;

            if ($request->hasFile('excel_file')) {
                if ($data->excel_file) @unlink(public_path($data->excel_file));
                $dir  = public_path('upload/excess_inventory/excel');
                if (!file_exists($dir)) mkdir($dir, 0755, true);
                $file = $request->file('excel_file');
                $name = uniqid('excel_', true) . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $name);
                $data->excel_file = 'upload/excess_inventory/excel/' . $name;
            }

            if ($request->hasFile('pdf_file')) {
                if ($data->pdf_file) @unlink(public_path($data->pdf_file));
                $dir  = public_path('upload/excess_inventory/pdf');
                if (!file_exists($dir)) mkdir($dir, 0755, true);
                $file = $request->file('pdf_file');
                $name = uniqid('pdf_', true) . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $name);
                $data->pdf_file = 'upload/excess_inventory/pdf/' . $name;
            }

            $data->save();
            DB::commit();

            return back()->with(['message' => 'Updated successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('ExcessInventory Update Error: ' . $e->getMessage());
            return back()->withInput()->with(['message' => 'Failed to update.', 'alert-type' => 'error']);
        }
    }

    public function Delete($id)
    {
        try {
            $data = ExcessInventory::findOrFail($id);
            if ($data->excel_file) @unlink(public_path($data->excel_file));
            if ($data->pdf_file)   @unlink(public_path($data->pdf_file));
            $data->delete();

            return back()->with(['message' => 'Deleted successfully!', 'alert-type' => 'success']);
        } catch (\Throwable $e) {
            Log::error('ExcessInventory Delete Error: ' . $e->getMessage());
            return back()->with(['message' => 'Failed to delete.', 'alert-type' => 'error']);
        }
    }
}
