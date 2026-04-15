<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        // General
        if ($request->has('koperasi_name')) Setting::set('koperasi_name', $request->koperasi_name);
        if ($request->has('koperasi_address')) Setting::set('koperasi_address', $request->koperasi_address);
        if ($request->has('koperasi_email')) Setting::set('koperasi_email', $request->koperasi_email);
        if ($request->has('koperasi_phone')) Setting::set('koperasi_phone', $request->koperasi_phone);

        // Simpanan
        if ($request->has('simpanan_wajib_nominal')) Setting::set('simpanan_wajib_nominal', $request->simpanan_wajib_nominal, 'integer');
        Setting::set('simpanan_pokok_active', $request->has('simpanan_pokok_active'), 'boolean');
        Setting::set('simpanan_wajib_active', $request->has('simpanan_wajib_active'), 'boolean');
        Setting::set('simpanan_monosuko_active', $request->has('simpanan_monosuko_active'), 'boolean');
        Setting::set('simpanan_dpu_active', $request->has('simpanan_dpu_active'), 'boolean');
        Setting::set('simpanan_sukarela_active', $request->has('simpanan_sukarela_active'), 'boolean');

        // Pinjaman
        if ($request->has('pinjaman_bunga')) Setting::set('pinjaman_bunga', $request->pinjaman_bunga, 'integer');
        if ($request->has('pinjaman_max')) Setting::set('pinjaman_max', $request->pinjaman_max, 'integer');
        if ($request->has('pinjaman_max_tenor')) Setting::set('pinjaman_max_tenor', $request->pinjaman_max_tenor, 'integer');

        // System
        Setting::set('system_log_active', $request->has('system_log_active'), 'boolean');
        if ($request->has('admin_theme')) Setting::set('admin_theme', $request->admin_theme);

        // Admin Account details
        $admin = Auth::user();
        $adminRules = [];
        if ($request->filled('admin_name')) $adminRules['admin_name'] = 'string|max:255';
        if ($request->filled('admin_email')) $adminRules['admin_email'] = 'email|unique:users,email,' . $admin->id;
        
        if ($request->filled('admin_old_password') || $request->filled('admin_new_password')) {
            $adminRules['admin_old_password'] = 'required';
            $adminRules['admin_new_password'] = 'required|min:8|same:admin_new_password_confirmation';
        }

        $request->validate($adminRules);

        if ($request->filled('admin_name')) $admin->name = $request->admin_name;
        if ($request->filled('admin_email')) $admin->email = $request->admin_email;

        if ($request->filled('admin_new_password')) {
            if (Hash::check($request->admin_old_password, $admin->password)) {
                $admin->password = Hash::make($request->admin_new_password);
            } else {
                return back()->with('error', 'Password lama tidak sesuai.');
            }
        }
        $admin->save();

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }
}
