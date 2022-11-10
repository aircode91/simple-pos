<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PembelianDetailController extends Controller
{
    public function index()
    {
        $purchase_id = session('purchase_id');
        $produk = Produk::orderBy('name')->get();
        $supplier_id = session('supplier_id');
        $supplier = Supplier::find($supplier_id);
        $discount = Pembelian::find($purchase_id)->discount ?? 0;

        if (!$supplier) abort(404);

        // return [$purchase_id, $supplier_id, $produk, $supplier, $discount];

        return view('pembelian_detail.index', compact('purchase_id', 'produk', 'supplier', 'discount'));
    }

    public function data($id)
    {
        $detail = PembelianDetail::where('purchase_id', $id)
            ->with('product')
            ->get();

        // return $detail;
        // $data = array();
        $quantity = 0;
        $total_item = 0;

        foreach ($detail as $item) {
            $row = array();
            $row['code'] = '<span class="label label-success">' . $item->product['code'] . '</span';
            $row['name'] = $item->product['name'];
            $row['price_buy']  = 'Rp. ' . format_uang($item->price_buy);
            $row['quantity']      = '<input type="number" class="form-control input-sm quantity" data-id="' . $item->id . '" value="' . $item->quantity . '">';
            $row['subtotal']    = 'Rp. ' . format_uang($item->subtotal);
            $row['action']        = '<button onclick="deleteData(`' . route('pembelian_detail.destroy', $item->id) . '`)" class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>';
            $data[] = $row;

            $quantity += $item->price_buy * $item->quantity;
            $total_item += $item->quantity;
        }
        $data[] = [
            'code' => '
                <div class="total hide">' . $quantity . '</div>
                <div class="total_item hide">' . $total_item . '</div>',
            'name' => '',
            'price_buy'  => '',
            'quantity'      => '',
            'subtotal'    => '',
            'action'        => '',
        ];

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->rawColumns(['action', 'code', 'quantity'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $produk = Produk::where('id', $request->product_id)->first();
        if (!$produk) {
            return response()->json('Data gagal disimpan', 400);
        }

        $detail = new PembelianDetail();
        $detail->purchase_id = $request->purchase_id;
        $detail->product_id = $produk->id;
        $detail->price_buy = $produk->price_buy;
        $detail->quantity = 1;
        $detail->subtotal = $produk->price_buy;
        $detail->save();

        return response()->json('Data berhasil disimpan', 200);
    }

    public function update(Request $request, $id)
    {
        $detail = PembelianDetail::find($id);
        $detail->quantity = $request->quantity;
        $detail->subtotal = $detail->price_buy * $request->quantity;
        $detail->update();
    }

    public function destroy($id)
    {
        $detail = PembelianDetail::find($id);
        $detail->delete();

        return response(null, 204);
    }

    public function loadForm($diskon, $total)
    {
        $bayar = $total - ($diskon / 100 * $total);
        $data  = [
            'totalrp' => format_uang($total),
            'paid' => $bayar,
            'bayarrp' => format_uang($bayar),
            'terbilang' => ucwords(terbilang($bayar) . ' Rupiah')
        ];

        return response()->json($data);
    }
}
