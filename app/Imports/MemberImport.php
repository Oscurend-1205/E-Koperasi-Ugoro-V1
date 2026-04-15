<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Simpanan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MemberImport implements ToCollection, WithStartRow
{
    /**
     * StartRow: Data starts at row 3 (skip 2 header rows).
     */
    public function startRow(): int
    {
        return 3;
    }

    /**
     * Process each row into User and Simpanan records.
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Skip empty rows (must have NIA and Name)
            if (empty($row[1]) && empty($row[2])) {
                continue;
            }

            $nia = (string) ($row[1] ?? '');
            $name = (string) ($row[2] ?? '');
            
            if (!$nia || !$name) continue;

            // Cari atau buat User
            $user = User::firstOrCreate(
                ['no_anggota' => $nia],
                [
                    'name' => $name,
                    'nik' => '-',
                    'alamat' => '-',
                    'no_hp' => '-',
                    'password' => Hash::make($nia), // default password is NIA
                    'role' => 'user'
                ]
            );

            // Kalau nama di upload beda, bisa juga kita update (optional)
            // Jika butuh update: $user->update(['name' => $name]);

            $pokok    = $this->parseCurrency($row[3] ?? 0);
            $wajib    = $this->parseCurrency($row[4] ?? 0);
            $monosuko = $this->parseCurrency($row[5] ?? 0);
            $dpu      = $this->parseCurrency($row[6] ?? 0);

            // Insert Simpanan Pokok
            if ($pokok > 0) {
                Simpanan::create([
                    'user_id' => $user->id,
                    'jenis_simpanan' => 'Pokok',
                    'jumlah' => $pokok,
                    'tanggal_transaksi' => now(),
                    'keterangan' => 'Import Excel'
                ]);
            }

            // Insert Simpanan Wajib
            if ($wajib > 0) {
                Simpanan::create([
                    'user_id' => $user->id,
                    'jenis_simpanan' => 'Wajib',
                    'jumlah' => $wajib,
                    'tanggal_transaksi' => now(),
                    'keterangan' => 'Import Excel'
                ]);
            }

            // Insert Simpanan Monosuko
            if ($monosuko > 0) {
                Simpanan::create([
                    'user_id' => $user->id,
                    'jenis_simpanan' => 'Monosuko',
                    'jumlah' => $monosuko,
                    'tanggal_transaksi' => now(),
                    'keterangan' => 'Import Excel'
                ]);
            }

            // Insert DPU
            if ($dpu > 0) {
                Simpanan::create([
                    'user_id' => $user->id,
                    'jenis_simpanan' => 'DPU',
                    'jumlah' => $dpu,
                    'tanggal_transaksi' => now(),
                    'keterangan' => 'Import Excel'
                ]);
            }
        }
    }

    /**
     * Cleaning logic: handles both dot and comma formatting (e.g. 10.000.000 or 1,000,000).
     */
    private function parseCurrency($value)
    {
        if (empty($value) && $value !== '0' && $value !== 0) return 0;
        
        // If it's already a float/int
        if (is_int($value) || is_float($value)) return (float) $value;

        // Convert to string safely and clean currency formatting
        $v = (string) $value;
        $v = preg_replace('/[^0-9\.,\-]/', '', $v);

        if (empty($v)) return 0;

        // Count commas and dots
        $dotCount = substr_count($v, '.');
        $commaCount = substr_count($v, ',');

        if ($dotCount > 0 && $commaCount > 0) {
            // Both exist: "1.000.000,00" or "1,000,000.00"
            $lastDot = strrpos($v, '.');
            $lastComma = strrpos($v, ',');
            
            if ($lastDot > $lastComma) {
                // US style: 1,000.50
                $v = str_replace(',', '', $v);
            } else {
                // Indo style: 1.000,50
                $v = str_replace('.', '', $v);
                $v = str_replace(',', '.', $v);
            }
        } elseif ($dotCount > 1) {
            // Multiple dots => thousand separator: "10.000.000"
            $v = str_replace('.', '', $v);
        } elseif ($commaCount > 1) {
            // Multiple commas => thousand separator: "10,000,000"
            $v = str_replace(',', '', $v);
        } else {
            // Exactly 1 dot OR exactly 1 comma OR neither
            if ($commaCount === 1) {
                $parts = explode(',', $v);
                // If 3 digits after comma, it's thousand separator: "200,000"
                if (strlen($parts[1]) === 3) {
                    $v = str_replace(',', '', $v);
                } else {
                    // decimal: "200,50", "200,00"
                    $v = str_replace(',', '.', $v);
                }
            } elseif ($dotCount === 1) {
                $parts = explode('.', $v);
                // If 3 digits after dot, it's thousand separator: "200.000"
                if (strlen($parts[1]) === 3) {
                    $v = str_replace('.', '', $v);
                }
            }
        }

        return (float) $v;
    }
}
