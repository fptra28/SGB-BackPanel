<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil satu user sebagai penulis berita (pastikan ada user di database)
        $author = DB::table('users')->first();

        if (!$author) {
            $this->command->warn("Tidak ada user di database. Harap buat user terlebih dahulu.");
            return;
        }

        // Data berita contoh
        $beritas = [];

        for ($i = 1; $i <= 10; $i++) {
            $beritas[] = [
                'image1' => 'default.jpg',
                'Judul' => 'Berita ' . $i,
                'Isi' => 'Ini adalah isi dari berita ke-' . $i . ' yang sangat menarik untuk dibaca.',
                'author_id' => $author->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Masukkan data ke tabel `beritas`
        DB::table('beritas')->insert($beritas);
    }
}
