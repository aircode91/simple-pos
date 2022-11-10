<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Produk;
use App\Models\Setting;
use Illuminate\Http\Request;
use PDF;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('penjualan.index');
    }

    public function data()
    {
        $sales = Penjualan::with('member')->orderBy('id', 'desc')->get();
        // dd($sales);

        return datatables()
            ->of($sales)
            ->addIndexColumn()
            ->addColumn('total_item', function ($sales) {
                return format_uang($sales->total_item);
            })
            ->addColumn('total_harga', function ($sales) {
                return 'Rp. ' . format_uang($sales->total_price);
            })
            ->addColumn('bayar', function ($sales) {
                return 'Rp. ' . format_uang($sales->paid);
            })
            ->addColumn('tanggal', function ($sales) {
                return tanggal_indonesia($sales->created_at, false);
            })
            ->addColumn('kode_member', function ($sales) {
                $member = $sales->member->code ?? '';
                return '<span class="label label-success">' . $member . '</spa>';
            })
            ->editColumn('diskon', function ($sales) {
                return $sales->discount . '%';
            })
            ->editColumn('kasir', function ($sales) {
                return $sales->user->name ?? '';
            })
            ->addColumn('aksi', function ($sales) {
                return '
                    <button onclick="showDetail(`' . route('penjualan.show', $sales->id) . '`)" class="btn btn-sm btn-info "><i class="fa fa-eye"></i></button>
                    <button onclick="deleteData(`' . route('penjualan.destroy', $sales->id) . '`)" class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['aksi', 'kode_member'])
            ->make(true);
    }

    public function create()
    {
        // dd('masuk pak eko!!');
        $penjualan = new Penjualan();
        $penjualan->member_id = null;
        $penjualan->total_item = 0;
        $penjualan->total_price = 0;
        $penjualan->discount = 0;
        $penjualan->paid = 0;
        $penjualan->received = 0;
        $penjualan->user_id = auth()->id();
        $penjualan->save();

        session(['sale_id' => $penjualan->id]);
        return redirect()->route('transaksi.index');
    }

    public function store(Request $request)
    {
        $penjualan = Penjualan::findOrFail($request->id_penjualan);
        $penjualan->member_id = $request->member_id;
        $penjualan->total_item = $request->total_item;
        $penjualan->total_price = $request->total;
        $penjualan->discount = $request->diskon;
        $penjualan->paid = $request->bayar;
        $penjualan->received = $request->diterima;
        $penjualan->update();

        $detail = PenjualanDetail::where('sale_id', $penjualan->id)->get();
        foreach ($detail as $item) {
            $item->discount = $request->diskon;
            $item->update();

            $produk = Produk::find($item->product_id);
            $produk->stock -= $item->quantity;
            $produk->update();
        }

        return redirect()->route('transaksi.selesai');
    }

    public function show($id)
    {
        $detail = PenjualanDetail::with('produk')->where('sale_id', $id)->get();

        return datatables()
            ->of($detail)
            ->addIndexColumn()
            ->addColumn('kode_produk', function ($detail) {
                return '<span class="label label-success">' . $detail->produk->code . '</span>';
            })
            ->addColumn('nama_produk', function ($detail) {
                return $detail->produk->name;
            })
            ->addColumn('harga_jual', function ($detail) {
                return 'Rp. ' . format_uang($detail->price_sell);
            })
            ->addColumn('jumlah', function ($detail) {
                return format_uang($detail->quantity);
            })
            ->addColumn('subtotal', function ($detail) {
                return 'Rp. ' . format_uang($detail->subtotal);
            })
            ->rawColumns(['kode_produk'])
            ->make(true);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);
        $detail    = PenjualanDetail::where('sale_id', $penjualan->id)->get();
        foreach ($detail as $item) {
            $produk = Produk::find($item->product_id);
            if ($produk) {
                $produk->stock += $item->quantity;
                $produk->update();
            }

            $item->delete();
        }

        $penjualan->delete();

        return response(null, 204);
    }

    public function selesai()
    {
        $setting = Setting::first();

        return view('penjualan.selesai', compact('setting'));
    }

    public function notaKecil()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('sale_id'));
        if (!$penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('sale_id', session('sale_id'))
            ->get();

        return view('penjualan.nota_kecil', compact('setting', 'penjualan', 'detail'));
    }

    public function notaBesar()
    {
        $setting = Setting::first();
        $penjualan = Penjualan::find(session('sale_id'));
        if (!$penjualan) {
            abort(404);
        }
        $detail = PenjualanDetail::with('produk')
            ->where('sale_id', session('sale_id'))
            ->get();

        $pdf = \PDF::loadView('penjualan.nota_besar', compact('setting', 'penjualan', 'detail'));
        $pdf->setPaper(0, 0, 609, 440, 'potrait');
        return $pdf->stream('Transaksi-' . date('Y-m-d-his') . '.pdf');
    }
}
