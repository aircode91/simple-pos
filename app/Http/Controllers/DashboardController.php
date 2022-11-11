<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Member;
use App\Models\Pembelian;
use App\Models\Pengeluaran;
use App\Models\Penjualan;
use App\Models\Produk;
use App\Models\Supplier;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $kategori = Kategori::count();
        $produk = Produk::count();
        $supplier = Supplier::count();
        $member = Member::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_penjualan = Penjualan::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('paid');
            $total_pembelian = Pembelian::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('paid');
            $total_pengeluaran = Pengeluaran::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('amount');

            $pendapatan = $total_penjualan - $total_pembelian - $total_pengeluaran;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        $tanggal_awal = date('Y-m-01');

        $data = json_decode(json_encode([
            ['title' => 'Total Kategori', 'value' => $kategori, 'link' => 'kategori.index', 'icon' => 'ni-bullet-list-67'],
            ['title' => 'Total Product', 'value' => $produk, 'link' => 'produk.index', 'icon' => 'ni-app'],
            ['title' => 'Total Supplier', 'value' => $supplier, 'link' => 'supplier.index', 'icon' => 'ni-delivery-fast'],
            ['title' => 'Total Member', 'value' => $member, 'link' => 'member.index', 'icon' => 'ni-single-02']
        ]));

        if (auth()->user()->level == 1) {
            return view('admin.dashboard', compact('data', 'kategori', 'produk', 'supplier', 'member', 'tanggal_awal', 'tanggal_akhir', 'data_tanggal', 'data_pendapatan'));
        } else {
            return view('kasir.dashboard');
        }
    }
}
