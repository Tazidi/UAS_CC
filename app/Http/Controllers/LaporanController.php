<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function index()
    {
        $pemesanan = Pemesanan::with('rute', 'penumpang')->orderBy('created_at', 'desc')->get();
        return view('server.laporan.index', compact('pemesanan'));
    }

    public function petugas()
    {
        return view('client.petugas');
    }

    public function kode(Request $request)
    {
        return redirect()->route('transaksi.show', $request->kode);
    }

    public function show($id)
    {
        $data = Pemesanan::with('rute.transportasi.category', 'penumpang')->where('kode', $id)->first();
        if ($data) {
            return view('server.laporan.show', compact('data'));
        } else {
            return redirect()->back()->with('error', 'Kode Transaksi Tidak Ditemukan!');
        }
    }

    public function pembayaran($id)
    {
        Pemesanan::find($id)->update([
            'status' => 'Sudah Bayar',
            'petugas_id' => Auth::user()->id
        ]);

        return redirect()->back()->with('success', 'Pembayaran Ticket Success!');
    }

    public function history()
    {
        $pemesanan = Pemesanan::with('rute.transportasi')->where('penumpang_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('client.history', compact('pemesanan'));
    }

    public function downloadPDF($id)
{
    $data = Pemesanan::with('rute.transportasi', 'penumpang')->findOrFail($id);

    // Buat PDF dari blade view
    $pdf = Pdf::loadView('server.laporan.pdf', ['data' => $data]);

    // Hasil PDF dalam bentuk binary
    $pdfContent = $pdf->output();

    // Nama file PDF
    $fileName = 'ticket-' . $data->kode . '.pdf';

    // Upload ke S3 di folder 'tickets/'
    Storage::disk('s3')->put('tickets/' . $fileName, $pdfContent, 'public');

    // (Opsional) Ambil URL publiknya jika kamu ingin pakai nanti
    // $s3Url = Storage::disk('s3')->url('tickets/' . $fileName);

    // Kembalikan response download ke user
    return response()->streamDownload(function () use ($pdfContent) {
        echo $pdfContent;
    }, $fileName);
}

}
