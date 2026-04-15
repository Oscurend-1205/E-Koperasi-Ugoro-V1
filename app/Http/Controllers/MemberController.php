<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MemberImport;

class MemberController extends Controller
{
    /**
     * Show the import form.
     */
    public function importForm()
    {
        return view('admin.import_member');
    }

    /**
     * Process the uploaded Excel file.
     */
    public function importProcess(Request $request)
    {
        // Validation: Ensure file is present and has correct format
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240' // Max 10MB
        ]);

        try {
            // Import logic using MemberImport class
            Excel::import(new MemberImport, $request->file('file'));

            return redirect()->back()->with('success', 'Data Anggota & Simpanan berhasil diimport ke database!');
        } catch (\Exception $e) {
            // Log error if needed: \Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat import: ' . $e->getMessage());
        }
    }
}
