<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat kategori berita terlebih dahulu
        $categories = [
            ['name' => 'Pengumuman', 'slug' => 'pengumuman', 'description' => 'Pengumuman resmi kampus', 'is_active' => true],
            ['name' => 'Kegiatan', 'slug' => 'kegiatan', 'description' => 'Kegiatan kampus dan mahasiswa', 'is_active' => true],
            ['name' => 'Prestasi', 'slug' => 'prestasi', 'description' => 'Prestasi mahasiswa dan kampus', 'is_active' => true],
        ];

        foreach ($categories as $cat) {
            \App\Models\NewsCategory::create($cat);
        }

        // Buat berita sample
        $news = [
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Penerimaan Mahasiswa Baru Tahun Akademik 2025/2026',
                'slug' => 'penerimaan-mahasiswa-baru-2025-2026',
                'excerpt' => 'Akademi Keperawatan membuka pendaftaran mahasiswa baru untuk tahun akademik 2025/2026. Daftar sekarang!',
                'content' => 'Akademi Keperawatan dengan bangga mengumumkan pembukaan pendaftaran mahasiswa baru untuk tahun akademik 2025/2026. Kami menawarkan program pendidikan berkualitas dengan fasilitas modern dan tenaga pengajar berpengalaman.

Persyaratan:
- Lulusan SMA/SMK/sederajat
- Nilai rata-rata minimal 7.0
- Sehat jasmani dan rohani
- Lulus tes masuk

Pendaftaran dibuka mulai 1 Desember 2024 hingga 30 Maret 2025. Informasi lebih lanjut dapat menghubungi bagian admisi atau kunjungi website resmi kami.',
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'views' => 150,
            ],
            [
                'category_id' => 2,
                'user_id' => 1,
                'title' => 'Workshop Keterampilan Keperawatan Tingkat Lanjut',
                'slug' => 'workshop-keterampilan-keperawatan',
                'excerpt' => 'Mahasiswa semester 5 mengikuti workshop intensive keterampilan keperawatan dengan narasumber profesional.',
                'content' => 'Pada tanggal 28-29 Oktober 2024, mahasiswa semester 5 Program Studi Keperawatan mengikuti workshop keterampilan keperawatan tingkat lanjut. Workshop ini menghadirkan narasumber dari beberapa rumah sakit ternama.

Materi yang diajarkan meliputi:
- Perawatan luka modern
- Teknik injeksi dan infus terbaru
- Komunikasi terapeutik dengan pasien
- Penanganan kegawatdaruratan

Workshop ini mendapat respons positif dari para mahasiswa karena sangat membantu mereka dalam mempersiapkan diri untuk praktik klinik.',
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'views' => 89,
            ],
            [
                'category_id' => 3,
                'user_id' => 1,
                'title' => 'Mahasiswa Raih Juara 1 Lomba Karya Tulis Ilmiah Nasional',
                'slug' => 'juara-1-lomba-kti-nasional',
                'excerpt' => 'Tim mahasiswa dari kampus kami berhasil meraih juara 1 dalam Lomba Karya Tulis Ilmiah tingkat nasional.',
                'content' => 'Kabar membanggakan datang dari tim mahasiswa kami yang terdiri dari Siti Aminah, Budi Santoso, dan Rina Wati. Mereka berhasil meraih juara 1 dalam Lomba Karya Tulis Ilmiah (KTI) Bidang Kesehatan tingkat nasional yang diselenggarakan oleh Universitas Indonesia.

Karya tulis mereka berjudul "Inovasi Pelayanan Keperawatan Berbasis Teknologi untuk Meningkatkan Kualitas Hidup Lansia" dinilai sangat inovatif dan applicable oleh dewan juri.

Pencapaian ini membuktikan bahwa mahasiswa kami tidak hanya unggul dalam praktik keperawatan, tetapi juga dalam penelitian dan pengembangan ilmu pengetahuan.

Selamat kepada para pemenang!',
                'status' => 'published',
                'published_at' => now()->subDays(7),
                'views' => 234,
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'title' => 'Jadwal Ujian Akhir Semester Gasal 2024/2025',
                'slug' => 'jadwal-uas-gasal-2024-2025',
                'excerpt' => 'Pengumuman jadwal Ujian Akhir Semester (UAS) untuk semester gasal tahun akademik 2024/2025.',
                'content' => 'Kepada seluruh mahasiswa Akademi Keperawaran,

Dengan ini kami mengumumkan jadwal Ujian Akhir Semester (UAS) untuk semester gasal tahun akademik 2024/2025:

Waktu Pelaksanaan: 15 - 22 Desember 2024
Sistem Ujian: Campuran (Online dan Offline)

Ketentuan:
1. Mahasiswa wajib hadir 15 menit sebelum ujian dimulai
2. Membawa kartu ujian dan KTM
3. Tidak diperkenankan membawa HP ke ruang ujian
4. Batas minimal kehadiran 75% untuk dapat mengikuti UAS

Jadwal detail per mata kuliah akan diinformasikan melalui portal akademik masing-masing.

Sukses untuk UAS!',
                'status' => 'published',
                'published_at' => now()->subDays(1),
                'views' => 312,
            ],
            [
                'category_id' => 2,
                'user_id' => 1,
                'title' => 'Bakti Sosial Pemeriksaan Kesehatan Gratis di Desa Sukamaju',
                'slug' => 'bakti-sosial-pemeriksaan-kesehatan-gratis',
                'excerpt' => 'Mahasiswa dan dosen melaksanakan bakti sosial pemeriksaan kesehatan gratis untuk masyarakat.',
                'content' => 'Sebagai bentuk pengabdian kepada masyarakat, mahasiswa dan dosen Akademi Keperawatan mengadakan bakti sosial pemeriksaan kesehatan gratis di Desa Sukamaju pada tanggal 2 November 2024.

Kegiatan yang diikuti oleh 50 mahasiswa dan 10 dosen ini memberikan layanan:
- Pemeriksaan tekanan darah
- Cek gula darah
- Konsultasi kesehatan
- Edukasi pola hidup sehat
- Pembagian obat-obatan gratis

Total masyarakat yang terlayani mencapai 300 orang. Kegiatan ini mendapat apresiasi tinggi dari Kepala Desa dan masyarakat setempat.

Kegiatan bakti sosial seperti ini akan terus dilaksanakan sebagai wujud kepedulian kampus terhadap kesehatan masyarakat.',
                'status' => 'published',
                'published_at' => now()->subDays(3),
                'views' => 127,
            ],
            [
                'category_id' => 3,
                'user_id' => 1,
                'title' => 'Alumni Diterima Bekerja di Rumah Sakit Ternama',
                'slug' => 'alumni-bekerja-rs-ternama',
                'excerpt' => '15 alumni angkatan 2024 berhasil diterima bekerja di berbagai rumah sakit ternama di Indonesia.',
                'content' => 'Kabar membanggakan kembali datang dari alumni Akademi Keperawatan angkatan 2024. Sebanyak 15 alumni berhasil diterima bekerja di berbagai rumah sakit ternama di Indonesia, termasuk:

- RS Siloam (Jakarta) - 4 orang
- RS Mayapada (Jakarta) - 3 orang  
- RS Bethsaida (Tangerang) - 2 orang
- RSUP Dr. Sardjito (Yogyakarta) - 3 orang
- RS Hermina (Bekasi) - 3 orang

Pencapaian ini membuktikan kualitas lulusan kami yang diakui oleh industri kesehatan. Para alumni telah menjalani training intensif dan siap memberikan pelayanan keperawatan terbaik.

Kami bangga dengan prestasi alumni dan berharap mereka terus berkembang di dunia profesional.',
                'status' => 'published',
                'published_at' => now()->subDays(10),
                'views' => 189,
            ],
        ];

        foreach ($news as $item) {
            \App\Models\News::create($item);
        }
    }
}
