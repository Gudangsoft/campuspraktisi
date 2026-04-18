<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            // Top Bar Pages
            [
                'title' => 'Staf',
                'slug' => 'staf',
                'excerpt' => 'Informasi untuk staf dan dosen',
                'content' => "Selamat datang di portal staf.\n\nHalaman ini berisi informasi untuk staf dan dosen:\n- Portal akademik staf\n- Sistem absensi\n- Pengajuan cuti\n- Download form\n- Kontak bagian kepegawaian",
                'template' => 'default',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'title' => 'Mahasiswa',
                'slug' => 'mahasiswa',
                'excerpt' => 'Portal layanan mahasiswa',
                'content' => "Portal Mahasiswa\n\nLayanan untuk mahasiswa:\n- Sistem Informasi Akademik (SIAKAD)\n- Jadwal kuliah\n- KRS Online\n- Nilai & transkrip\n- Pembayaran UKT\n- Beasiswa\n- Kalender akademik",
                'template' => 'default',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'title' => 'Alumni',
                'slug' => 'alumni',
                'excerpt' => 'Jaringan dan layanan alumni',
                'content' => "Alumni Network\n\nLayanan untuk alumni:\n- Registrasi alumni\n- Tracer study\n- Lowongan kerja\n- Event alumni\n- Legalisir ijazah\n- Surat keterangan\n- Alumni directory",
                'template' => 'default',
                'is_active' => true,
                'order' => 3,
            ],
            
            // Main Navigation Pages
            [
                'title' => 'Profil',
                'slug' => 'profil',
                'excerpt' => 'Profil kampus kami',
                'content' => "Profil Institusi\n\nSejarah Singkat\nKampus kami didirikan dengan visi menjadi institusi pendidikan keperawatan terkemuka yang menghasilkan lulusan berkualitas dan berintegritas.\n\nFasilitas\n- Laboratorium Keperawatan Modern\n- Perpustakaan Digital\n- Ruang Kelas AC\n- Asrama Mahasiswa\n- Klinik Pratama\n- Pusat Simulasi Medis\n\nAkreditasi\nInstitusi kami telah terakreditasi BAN-PT dengan peringkat A.",
                'template' => 'landing',
                'is_active' => true,
                'order' => 10,
            ],
            [
                'title' => 'Visi & Misi',
                'slug' => 'visi-misi',
                'excerpt' => 'Visi dan misi institusi',
                'content' => "VISI\nMenjadi institusi pendidikan keperawatan unggul yang menghasilkan tenaga kesehatan profesional, kompeten, dan beretika.\n\nMISI\n1. Menyelenggarakan pendidikan keperawatan berkualitas tinggi\n2. Mengembangkan penelitian di bidang keperawatan\n3. Melaksanakan pengabdian kepada masyarakat\n4. Membina kerjasama dengan institusi kesehatan\n5. Menghasilkan lulusan yang berkompetensi global",
                'template' => 'default',
                'is_active' => true,
                'order' => 11,
            ],
            [
                'title' => 'Sejarah',
                'slug' => 'sejarah',
                'excerpt' => 'Perjalanan sejarah institusi',
                'content' => "Sejarah Pendirian\n\n1980 - Pendirian\nDidirikan sebagai sekolah perawat kesehatan\n\n1995 - Perubahan Status\nMenjadi Akademi Keperawatan\n\n2005 - Akreditasi B\nMendapat akreditasi B dari BAN-PT\n\n2015 - Akreditasi A\nMeningkat menjadi akreditasi A\n\n2020 - Perluasan Kampus\nPembangunan gedung baru dan fasilitas modern",
                'template' => 'default',
                'is_active' => true,
                'order' => 12,
            ],
            [
                'title' => 'Penerimaan Mahasiswa Baru',
                'slug' => 'penerimaan',
                'excerpt' => 'Informasi PMB dan pendaftaran',
                'content' => "Penerimaan Mahasiswa Baru\n\nJalur Penerimaan:\n1. Jalur Reguler\n2. Jalur Prestasi\n3. Jalur Beasiswa\n\nPersyaratan:\n- Lulusan SMA/SMK/MA\n- Nilai rapor minimal 70\n- Sehat jasmani dan rohani\n- Bebas narkoba\n- Lulus tes seleksi\n\nBiaya Pendidikan:\n- Uang Pangkal: Rp 5.000.000\n- SPP per semester: Rp 3.500.000\n\nPendaftaran Online:\nDaftar melalui website: pmb.kampus.ac.id",
                'template' => 'landing',
                'is_active' => true,
                'order' => 20,
            ],
            [
                'title' => 'Program Sarjana',
                'slug' => 'sarjana',
                'excerpt' => 'Program Sarjana Keperawatan (S1)',
                'content' => "Program Sarjana Keperawatan (S.Kep)\n\nDurasi: 4 Tahun (8 Semester)\n\nKurikulum:\n- Anatomi & Fisiologi\n- Farmakologi\n- Keperawatan Dasar\n- Keperawatan Medikal Bedah\n- Keperawatan Anak\n- Keperawatan Maternitas\n- Keperawatan Jiwa\n- Keperawatan Komunitas\n- Manajemen Keperawatan\n- Praktik Klinik\n\nLulusan:\nGelar Sarjana Keperawatan (S.Kep) + Profesi Ners (Ns.)",
                'template' => 'default',
                'is_active' => true,
                'order' => 30,
            ],
            [
                'title' => 'Kontak Kami',
                'slug' => 'kontak',
                'excerpt' => 'Hubungi kami',
                'content' => "Untuk informasi lebih lanjut, silakan hubungi kami melalui kontak di bawah ini.",
                'template' => 'contact',
                'is_active' => true,
                'order' => 100,
            ],
        ];

        foreach ($pages as $page) {
            \App\Models\Page::create($page);
        }
    }
}
