<?php

namespace App\Http\Controllers;

use App\Models\Lapangan;
use App\Models\User;
use App\Models\User_Bayar;
use App\Models\User_Booking;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function booking()
    {
        $lapangan = Lapangan::all();

        return view(
            'booking',
            [
                'lapangan' => $lapangan
            ]
        );
    }

    public function bookingJadwal()
    {
        $jadwal = User_Booking::whereDate('tanggal', '>=', date('Y-m-d'))
            ->get();
        $lapangan = Lapangan::get();

        return view('jadwal', [
            'jadwal' => $jadwal,
            'lapangan' => $lapangan,
        ]);
    }

    public function bookingStore(Request $request)
    {
        if (Auth::check()) {
            $request->validate([
                'jenis' => 'required',
                'tanggal_pesan' => 'required',
                'jam_mulai' => 'required',
                'lama_bermain' => 'required',
            ]);

            // dump(date('Y-m-d', strtotime($request->tanggal_pesan)));
            // dd(date('Y-m-d'));

            $tanggal_sekrang = date('Y-m-d');
            $tanggal_pesan = date('Y-m-d', strtotime($request->tanggal_pesan));
            if ($tanggal_sekrang > $tanggal_pesan) {
                return redirect()->back()->with('message_fail', 'Tanggal sudah lewat!');
            }

            $lama_bermain = explode(':', $request->jam_mulai);
            $selesai_bermain = array(0 => (string) $lama_bermain[0] + $request->lama_bermain);
            $jam_awal = implode(':', $lama_bermain);
            $jam_habis = implode(':', array_replace($lama_bermain, $selesai_bermain));

            $jam_sekarang = date('H:i');
            $jam_pesan = date('H:i', strtotime($request->jam_mulai));
            // dump($jam_sekarang);
            // dd($jam_pesan);
            $jam_buka = date('H:i', strtotime('08:00'));
            $jam_tutup = date('H:i', strtotime('23:59'));

            if ($jam_pesan < $jam_buka) {
                return redirect()->back()->with('message_fail', 'Basket Viladelima belum buka!');
            }
            if ($jam_pesan > $jam_tutup && $jam_habis > $jam_tutup) {
                return redirect()->back()->with('message_fail', 'Basket Viladelima sudah tutup!');
            }

            if  ( $tanggal_sekrang == $tanggal_pesan ) {
                if ($jam_sekarang > $jam_pesan) {
                    return redirect()->back()->with('message_fail', 'Jam sudah lewat!');
                }
            }

            $user_booking = User_Booking::withTrashed()->orderBy('id', 'DESC')->first();
            // dd($user_booking);
            if ($user_booking == Null) {
                $booking_id = 'BF0001';
            } else {
                $numRow = $user_booking->id + 1;

                if ($numRow < 10) {
                    $booking_id = 'BF' . '000' . $numRow;
                } elseif ($numRow >= 10 && $numRow <= 99) {
                    $booking_id = 'BF' . '00' . $numRow;
                } elseif ($numRow >= 100 && $numRow <= 999) {
                    $booking_id = 'BF' . '0' . $numRow;
                } elseif ($numRow >= 1000 && $numRow <= 9999) {
                    $booking_id = 'BF' . $numRow;
                }
            }

            // dd($booking_id);

            $user = User::where('email', Auth::user()->email)
                ->first();

            $user_id = $user->user_id;

            $check_time_1 = User_Booking::where('lapangan_id', $request->lapangan_id)
                ->whereDate('tanggal', $request->tanggal_pesan)
                ->get();

            foreach ($check_time_1 as $row) {
                $waktu_awal_db = date('H:i', strtotime($row->jam_mulai));
                $waktu_awal = date('H:i', strtotime($jam_awal));
                $waktu_akhir = date('H:i', strtotime($jam_habis));

                if ($waktu_awal < $waktu_awal_db && $waktu_akhir > $waktu_awal_db) {
                    return redirect()->back()->with('message_fail', 'Jam sudah terpesan di jam ' . $waktu_awal_db . '!');
                }
            }

            $check = User_Booking::where('lapangan_id', $request->lapangan_id)
                ->whereDate('tanggal', $request->tanggal_pesan)
                ->whereTime('jam_mulai', '<=', $jam_awal)
                ->whereTime('jam_habis', '>=', $jam_awal);

            $check_data = $check->count();
            $check_time = $check->first();

            if ($check_data == 1) {
                return redirect()->back()->with('message_fail', 'Jam sudah ada yang pesan, dari jam ' . $check_time->jam_mulai . '-' . $check_time->jam_habis . '!');
            }

            $harga = str_replace('Rp. ', '', $request->harga);
            $total = str_replace('Rp. ', '', $request->total_harga);

            $harga_lapangan = str_replace('.', '', $harga);
            $harga_total = str_replace('.', '', $total);

            User_Booking::create([
                'booking_id' => $booking_id,
                'user_id' => $user_id,
                'lapangan_id' => $request->lapangan_id,
                'tanggal' => $request->tanggal_pesan,
                'lama_mulai' => $request->lama_bermain . " Jam",
                'jam_mulai' => $jam_awal,
                'jam_habis' => $jam_habis,
                'jenis' => $request->jenis,
                'harga_lapangan' => $harga_lapangan,
                'total' => $harga_total,
                'status' => 'Belum Bayar',
            ]);

            return redirect()->route('dashboard')->with('message_success', 'Booking berhasil, silahkan lakukan pembayaran 1x24 Jam.');
        } else {
            return redirect()->route('masuk');
        }
    }

    public function bookingDelete($booking_id)
    {
        $booking = User_Booking::where('booking_id', $booking_id)
            ->first();

        User_Booking::where('booking_id', $booking_id)
            ->update([
                'status' => 'Batal'
            ]);

        $booking->delete();
        return redirect()->route('dashboard')->with('message_success', 'Booking berhasil dibatalkan!');
    }

    public function bookingPayment(Request $request)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,png,jpeg,pdf'
        ]);

        $user = User::where('email', Auth::user()->email)
            ->first();

        $fileName = $request->booking_id . "_" . uniqid() . "." . $request->bukti_pembayaran->extension();
        $request->bukti_pembayaran->move(public_path('pembayaran'), $fileName);

        $fileLocation = 'pembayaran/';

        User_Booking::where('booking_id', $request->booking_id)
            ->update([
                'status' => 'Pending',
            ]);

        User_Bayar::create([
            'booking_id' => $request->booking_id,
            'user_id' => $user->user_id,
            'tanggal' => $request->tanggal_main . ', ' . $request->jam_mulai,
            'bukti_tf' => $fileLocation . $fileName,
            'tanggal_upload' => date('d M Y, H:i:s A'),
            'status' => 'Pending',
        ]);

        return redirect()->route('dashboard')->with('message_success', 'Berhasil!, Silahkan tunggu konfirmasi pembayaran dari admin!');
    }
}
