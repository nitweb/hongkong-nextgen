<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BulkOrder;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
    public function BulkOrderList()
    {
        $bulk_order_list = BulkOrder::with('product')->latest()->get();
        return view('backend.bulk_order.list', compact('bulk_order_list'));
    }

    public function BulkOrderDelete($id)
    {
        BulkOrder::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Bulk order deleted successfully!');
    }

    public function BulkOrderBulkDelete(Request $request)
    {
        $ids = $request->ids;
        if (!$ids) {
            return redirect()->back()->with('error', 'No bulk orders selected.');
        }

        \App\Models\BulkOrder::whereIn('id', $ids)->delete();

        return redirect()->back()->with('success', 'Selected bulk orders deleted successfully!');
    }
}
