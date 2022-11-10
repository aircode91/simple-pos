<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use PDF;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kategori = Kategori::orderBy('name', 'asc')->pluck('name', 'id');

        return view('produk.index', compact('kategori'));
    }

    public function data()
    {
        $produk = Produk::with('category')
            // leftJoin('kategori', 'kategori.id_kategori', 'produk.id_kategori')
            //     ->select('produk.*', 'nama_kategori')
            //     // ->orderBy('kode_produk', 'asc')
            ->get();

        // dd($produk);

        return datatables()
            ->of($produk)
            ->addIndexColumn()
            ->addColumn('select_all', function ($produk) {
                return '
                    <input type="checkbox" name="id[]" value="' . $produk->id . '">
                ';
            })
            ->editColumn('category_name', function ($produk) {
                return '<span class="label label-success">' . $produk->category->name . '</span>';
            })
            ->addColumn('code', function ($produk) {
                return '<span class="label label-success">' . $produk->code . '</span>';
            })
            ->addColumn('price_buy', function ($produk) {
                return format_uang($produk->price_buy);
            })
            ->addColumn('price_sell', function ($produk) {
                return format_uang($produk->price_sell);
            })
            ->addColumn('stock', function ($produk) {
                return format_uang((int) ($produk->stock + $produk->initial_stock));
            })
            ->addColumn('action', function ($produk) {
                return '
                    <button type="button" onclick="editForm(`' . route('produk.update', $produk->id) . '`)" class="btn btn-sm btn-info "><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`' . route('produk.destroy', $produk->id) . '`)" class="btn btn-sm btn-danger "><i class="fa fa-trash"></i></button>
                ';
            })
            ->rawColumns(['action', 'category_name', 'code', 'select_all'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $produk = Produk::latest()->first() ?? new Produk();
        $request['code'] = 'P' . tambah_nol_didepan((int)$produk->id + 1, 6);

        $produk = Produk::create($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $produk = Produk::find($id);

        return response()->json($produk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        $produk->update($request->all());

        return response()->json('Data berhasil disimpan', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        $produk->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $produk->delete();
        }

        return response(null, 204);
    }

    public function cetakBarcode(Request $request)
    {
        $dataproduk = array();
        foreach ($request->id_produk as $id) {
            $produk = Produk::find($id);
            $dataproduk[] = $produk;
        }

        $no  = 1;
        $pdf = PDF::loadView('produk.barcode', compact('dataproduk', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('produk.pdf');
    }
}
