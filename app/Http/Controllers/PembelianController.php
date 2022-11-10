<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Produk;
use App\Models\Supplier;

class PembelianController extends Controller
{
    public function index()
    {
        $supplier = Supplier::orderBy('name')->get();

        return view('pembelian.index', compact('supplier'));
    }

    public function data()
    {
        $pembelian = Pembelian::orderBy('id', 'desc')->get();

        return datatables()
            ->of($pembelian)
            ->addIndexColumn()
            ->addColumn('total_item', function ($pembelian) {
                return format_uang($pembelian->total_item);
            })
            ->addColumn('total_price', function ($pembelian) {
                return 'Rp. ' . format_uang($pembelian->total_price);
            })
            ->addColumn('paid', function ($pembelian) {
                return 'Rp. ' . format_uang($pembelian->paid);
            })
            ->addColumn('tanggal', function ($pembelian) {
                return tanggal_indonesia($pembelian->created_at, false);
            })
            ->addColumn('supplier', function ($pembelian) {
                return $pembelian->supplier->name;
            })
            ->editColumn('discount', function ($pembelian) {
                return $pembelian->discount . '%';
            })
            ->addColumn('action', function ($pembelian) {
                return '
                    <button onclick="showDetail(`' . route('pembelian.show', $pembelian->id) . '`)" class="btn btn-sm btn-info" title="Show Detail"><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`' . route('pembelian.destroy', $pembelian->id) . '`)" class="btn btn-sm btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create($id)
    {
        $pembelian = new Pembelian();
        $pembelian->supplier_id = $id;
        $pembelian->total_item  = 0;
        $pembelian->total_price = 0;
        $pembelian->discount      = 0;
        $pembelian->paid       = 0;
        $pembelian->save();

        session(['purchase_id' => $pembelian->id]);
        session(['supplier_id' => $pembelian->supplier_id]);

        return redirect()->route('pembelian_detail.index');
    }

    public function store(Request $request)
    {
        $pembelian = Pembelian::findOrFail($request->purchase_id);
        // return $pembelian;
        $pembelian->total_item = $request->total_item;
        $pembelian->total_price = $request->total_price;
        $pembelian->discount = $request->discount;
        $pembelian->paid = $request->paid;
        $pembelian->update();

        $detail = PembelianDetail::where('id', $pembelian->id)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->product_id);
            $produk->stock += $item->quantity;
            $produk->update();
        }

        return redirect()->route('pembelian.index');
    }

    public function show($id)
    {
        $detail = PembelianDetail::with('product')->findOrFail($id)->get();

        // return $detail;
        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('code', function ($detail) {
                return '<span class="label label-success">' . $detail->product->code . '</span>';
            })
            ->addColumn('name', function ($detail) {
                return $detail->product->name;
            })
            ->addColumn('price_buy', function ($detail) {
                return 'Rp. ' . format_uang($detail->price_buy);
            })
            ->addColumn('quantity', function ($detail) {
                return format_uang($detail->quantity);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->rawColumns(['code'])
            ->make(true);
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::find($id);
        $detail    = PembelianDetail::where('id', $pembelian->id)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->id);
            if ($produk) {
                $produk->stock -= $item->quantity;
                $produk->update();
            }
            $item->delete();
        }

        $pembelian->delete();

        return response(null, 204);
    }
}
