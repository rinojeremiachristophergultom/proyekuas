<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_Booking;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = User::where('email', Auth::user()->email)
            ->first();
        $booking_data = User_Booking::where('user_id', $user->user_id)
            ->whereDate('tanggal', '>=', date('Y-m-d'))
            ->where('status', '!=', 'Success')
            ->paginate(10);
        $history_booking_data = User_Booking::where('user_id', $user->user_id)
            ->withTrashed()
            ->paginate(10);

        return view('dashboard', [
            'booking_data' => $booking_data,
            'history_booking_data' => $history_booking_data,
        ]);
    }

    public function masuk(Request $request)
    {
        try {
            $user = User::where('username', $request->username)->orWhere('email', $request->username)->firstOrFail();

            if ($user) {
                if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
                    return redirect()->route('dashboard');
                }
            }
            return redirect()->back()->with('message_fail', 'Username/Email atau Password salah!');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('message_fail', 'Username/Email atau Password salah!');
        }
        return redirect()->back()->with('message_fail', 'Username/Email atau Password salah!');
    }

    public function daftar(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|regex:/^[\p{L}\s-]+$/u|max:255',
            'no_hp' => 'required|string|regex:/(08)[0-9]{9}/|max:255',
            'jk' => 'required|string',
            'alamat' => 'required|string',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|string|email|unique:users,username',
            'password' => 'required|string|min:8|same:password_confirmation',
            'password_confirmation' => 'required',
        ]);

        $user = User::withTrashed()->orderBy('id', 'DESC')->first();

        if ($user == Null) {
            $user_id = 'GSF0001';
        } else {
            $numRow = $user->id + 1;

            if ($numRow < 10) {
                $user_id = 'GSF' . '000' . $numRow;
            } elseif ($numRow >= 10 && $numRow <= 99) {
                $user_id = 'GSF' . '00' . $numRow;
            } elseif ($numRow >= 100 && $numRow <= 999) {
                $user_id = 'GSF' . '0' . $numRow;
            } elseif ($numRow >= 1000 && $numRow <= 9999) {
                $user_id = 'GSF' . $numRow;
            }
        }

        User::create([
            'user_id' => $user_id,
            'name' => $request->nama,
            'no_hp' => $request->no_hp,
            'jk' => $request->jk,
            'alamat' => $request->alamat,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user = User::where('username', $request->username)->orWhere('email', $request->email)->first();

        if (Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }
    }

    public function keluar(Request $request)
    {
        Auth::logout();
        return redirect()->route('masuk');
    }
}
