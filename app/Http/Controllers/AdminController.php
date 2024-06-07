<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Lapangan;
use App\Models\Rekening;
use App\Models\User;
use App\Models\User_Bayar;
use App\Models\User_Booking;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            $login = Admin::where('username', $request->username)->orWhere('email', $request->username)->firstOrFail();

            if ($login) {
                if (Hash::check($request->password, $login->password)) {
                    session(['admin_login' => true]);
                    session(['admin_email' => $login->email]);

                    return redirect(route('admin.index'));
                }
            }
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('message_fail', 'Username atau Password salah!');
        }
        return redirect()->back()->with('message_fail', 'Username atau Password salah!');
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect(route('admin.signin'));
    }

    public function index()
    {
        $admin = Admin::where('email', session('admin_email'))
            ->first();

        $total_user = User::all()
            ->count();
        $total_booking = User_Booking::all()
            ->count();
        $total_pending = User_Bayar::where('status', 'Pending')
            ->count();

        return view('admin.index', [
            'admin' => $admin,
            'total_user' => $total_user,
            'total_booking' => $total_booking,
            'total_pending' => $total_pending,
        ]);
    }

    public function user()
    {
        $admin = Admin::where('email', session('admin_email'))
            ->first();

        $user = User::get();

        return view('admin.user', [
            'admin' => $admin,
            'user' => $user,
        ]);
    }

    public function userDelete($id)
    {
        $user = User::where('id', $id)
            ->first();
        
        $user->delete();

        return redirect()->back()->with('message_success', 'User berhasil terhapus!');
    }

    public function booking()
    {
        $admin = Admin::where('email', session('admin_email'))
            ->first();

        $user_booking = User_Booking::select('*')
            ->where('status', '=', 'Sudah Bayar')
            ->get();

        return view('admin.booking', [
            'admin' => $admin,
            'user_booking' => $user_booking,
        ]);
    }

    public function pembayaran()
    {
        $admin = Admin::where('email', session('admin_email'))
            ->first();

        $booking = User_Bayar::select('*')
            ->where('bukti_tf', '!=', Null)
            ->where('status', '=', 'Pending')
            ->get();

        return view('admin.pembayaran', [
            'admin' => $admin,
            'booking' => $booking,
        ]);
    }

    public function pembayaranSuccess($booking_id)
    {
        User_Bayar::where('booking_id', $booking_id)
            ->update([
                'status' => 'Sudah Bayar'
            ]);
        User_Booking::where('booking_id', $booking_id)
            ->update([
                'status' => 'Sudah Bayar'
            ]);
        return redirect()->back()->with('message_success', 'Berhasil!');
    }

    public function pembayaranWarning($booking_id)
    {
        User_Bayar::where('booking_id', $booking_id)
            ->update([
                'status' => 'Error'
            ]);
        User_Booking::where('booking_id', $booking_id)
            ->update([
                'status' => 'Error'
            ]);
        return redirect()->back()->with('message_success', 'Berhasil!');
    }

    public function lapangan()
    {
        $admin = Admin::where('email', session('admin_email'))
            ->first();
        $lapangan = Lapangan::all();
        return view('admin.lapangan', [
            'admin' => $admin,
            'lapangan' => $lapangan,
        ]);
    }

    public function rekening()
    {
        $admin = Admin::where('email', session('admin_email'))
            ->first();

        $rekening = Rekening::get();

        return view('admin.rekening', [
            'admin' => $admin,
            'rekening' => $rekening,
        ]);
    }
    public function rekeningStore(Request $request)
    {
        $request->validate([
            'nama_rekening' => 'required',
            'nomer_rekening' => 'required',
        ]);

        Rekening::create([
            'nomer_rekening' => $request->nomer_rekening,
            'nama_rekening' => $request->nama_rekening,
        ]);

        return redirect()->back()->with('message_success', 'Rekening berhasil dibuat!');
    }
    
    public function rekeningEdit(Request $request)
    {
        Rekening::where('id', $request->id_rekening)
            ->update([
                'nama_rekening' => $request->nama_rekening1,
                'nomer_rekening' => $request->nomer_rekening1,
            ]);
        return redirect()->back()->with('message_success', 'Rekening berhasil diubah!');
    }

    public function rekeningDelete($id)
    {
        $rekening = Rekening::where('id', $id)
            ->first();
        
        $rekening->delete();

        return redirect()->back()->with('message_success', 'Rekening berhasil dihapus!');
    }

    public function lapanganStore(Request $request)
    {
        $request->validate([
            'nama_lapangan' => 'required',
            'keterangan' => 'required',
            'harga_siang' => 'required',
            'harga_malam' => 'required',
            'foto1' => 'required|file|mimes:png,jpg,jpeg',
            'foto2' => 'file|mimes:png,jpg,jpeg',
            'foto3' => 'file|mimes:png,jpg,jpeg',
        ]);

        $lapangan = Lapangan::orderBy('id', 'DESC')->first();

        if ($lapangan == Null) {
            $lapangan_id = 'LP0001';
        } else {
            $numRow = $lapangan->id + 1;

            if ($numRow < 10) {
                $lapangan_id = 'LP' . '000' . $numRow;
            } elseif ($numRow >= 10 && $numRow <= 99) {
                $lapangan_id = 'LP' . '00' . $numRow;
            } elseif ($numRow >= 100 && $numRow <= 999) {
                $lapangan_id = 'LP' . '0' . $numRow;
            } elseif ($numRow >= 1000 && $numRow <= 9999) {
                $lapangan_id = 'LP' . $numRow;
            }
        }

        $p_siang = str_replace('Rp. ', '', $request->harga_siang);
        $p_malam = str_replace('Rp. ', '', $request->harga_malam);

        $siang = str_replace('.', '', $p_siang);
        $malam = str_replace('.', '', $p_malam);

        // File Upload
        // File 1
        $fileName1 = $lapangan_id . "_" . uniqid() . "." . $request->foto1->extension();

        // File 2
        if ($request->foto2 == "") {
            $fileName2 = Null;
        } else {
            $fileName2 = $lapangan_id . "_" . uniqid() . "." . $request->foto2->extension();
        }

        // File 3
        if ($request->foto3 == "") {
            $fileName3 = Null;
        } else {
            $fileName3 = $lapangan_id . "_" . uniqid() . "." . $request->foto3->extension();
        }

        // Save File 1
        $request->foto1->move(public_path('lapangan'), $fileName1);

        // Save File 2
        if ($fileName2 != Null) {
            $request->foto2->move(public_path('lapangan'), $fileName2);
            $fileLocation2 = 'lapangan/' . $fileName2;
        } else {
            $fileLocation2 = Null;
        }

        // Save File 3
        if ($fileName3 != Null) {
            $request->foto3->move(public_path('lapangan'), $fileName3);
            $fileLocation3 = 'lapangan/' . $fileName3;
        } else {
            $fileLocation3 = Null;
        }

        $fileLocation1 = 'lapangan/' . $fileName1;

        Lapangan::create([
            'lapangan_id' => $lapangan_id,
            'nama' => $request->nama_lapangan,
            'keterangan' => $request->keterangan,
            'harga_siang' => $siang,
            'harga_malam' => $malam,
            'foto1' => $fileLocation1,
            'foto2' => $fileLocation2,
            'foto3' => $fileLocation3,
        ]);

        return redirect()->back()->with('message_success', 'Berhasil menambah lapangan!');
    }

    public function lapanganEdit(Request $request)
    {
        $lapangan = Lapangan::where('lapangan_id', $request->lapangan_id)
            ->first();
        $request->validate([
            'edit_nama' => 'required',
            'edit_keterangan' => 'required',
            'edit_harga_siang' => 'required',
            'edit_harga_malam' => 'required',
            'edit_foto1' => 'file|mimes:png,jpg,jpeg',
            'edit_foto2' => 'file|mimes:png,jpg,jpeg',
            'edit_foto3' => 'file|mimes:png,jpg,jpeg',
        ]);

        if ($request->edit_foto1 == Null) {
            $fileLocation1 = $lapangan->foto1;
        } else {
            $fileName1 = $request->lapangan_id . "_" . uniqid() . "." . $request->edit_foto1->extension();
            $request->edit_foto1->move(public_path('lapangan'), $fileName1);
            $fileLocation1 = 'lapangan/' . $fileName1;
        }
        if ($request->edit_foto2 == Null) {
            $fileLocation2 = $lapangan->foto2;
        } else {
            $fileName2 = $request->lapangan_id . "_" . uniqid() . "." . $request->edit_foto2->extension();
            $request->edit_foto2->move(public_path('lapangan'), $fileName2);
            $fileLocation2 = 'lapangan/' . $fileName2;
        }
        if ($request->edit_foto3 == Null) {
            $fileLocation3 = $lapangan->foto3;
        } else {
            $fileName3 = $request->lapangan_id . "_" . uniqid() . "." . $request->edit_foto3->extension();
            $request->foto3->move(public_path('lapangan'), $fileName3);
            $fileLocation3 = 'lapangan/' . $fileName3;
        }

        $p_siang = str_replace('Rp. ', '', $request->edit_harga_siang);
        $p_malam = str_replace('Rp. ', '', $request->edit_harga_malam);

        $siang = str_replace('.', '', $p_siang);
        $malam = str_replace('.', '', $p_malam);

        Lapangan::where('lapangan_id', $request->lapangan_id)
            ->update([
                'nama' => $request->edit_nama,
                'keterangan' => $request->edit_keterangan,
                'harga_siang' => $siang,
                'harga_malam' => $malam,
                'foto1' => $fileLocation1,
                'foto2' => $fileLocation2,
                'foto3' => $fileLocation3,
            ]);

        return redirect()->back()->with('message_success', 'Berhasil!');
    }

    public function lapanganDelete($lapangan_id)
    {
        $lapangan = Lapangan::where('lapangan_id', $lapangan_id)
            ->first();

        $lapangan->delete();

        return redirect()->back()->with('message_success', 'Berhasil!');
    }
}
