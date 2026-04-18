<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyNewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dummyNews = [
            [
                'title' => 'P-P2Par Berkolaborasi dengan Disparbutkepona Bangka Belitung untuk Wujudkan Pembangunan Pariwisata Berkelanjutan',
                'content' => '<p>Pada hari Rabu, 30 Oktober 2024, bertempat di Aula Graha Nusantara, telah dilaksanakan kegiatan kolaborasi antara Pusat Penelitian dan Pengembangan Pariwisata (P-P2Par) dengan Dinas Pariwisata, Budaya, Kepemudaan dan Olahraga (Disparbutkepona) Provinsi Kepulauan Bangka Belitung.</p><p>Kegiatan ini bertujuan untuk mewujudkan pembangunan pariwisata yang berkelanjutan di wilayah Bangka Belitung dengan menggabungkan keahlian penelitian dan pengembangan dari P-P2Par dengan pemahaman lokal dan implementasi kebijakan dari Disparbutkepona.</p><p>Dalam acara tersebut, kedua belah pihak membahas strategi pengembangan destinasi wisata, peningkatan kualitas SDM pariwisata, serta upaya pelestarian budaya lokal yang dapat menjadi daya tarik wisata berkelanjutan.</p>',
                'excerpt' => 'Kolaborasi strategis untuk pembangunan pariwisata berkelanjutan di Bangka Belitung',
                'category_id' => 2,
                'views' => rand(50, 200),
                'published_at' => now()->subDays(rand(1, 5)),
            ],
            [
                'title' => 'Mahasiswa Raih Prestasi di Kompetisi Astronomi Internasional IAAC 2025',
                'content' => '<p>Mahasiswa Sekolah Tinggi Ilmu Kesehatan (STIKES) Karya Bhakti Nusantara Magelang berhasil meraih prestasi gemilang dalam Kompetisi Astronomi Internasional IAAC (International Astronomy and Astrophysics Competition) 2025 yang diselenggarakan secara daring.</p><p>Kompetisi yang diikuti oleh ribuan peserta dari berbagai negara ini menguji kemampuan peserta dalam bidang astronomi dan astrofisika. Tim dari STIKES Karya Bhakti Nusantara berhasil menembus babak final dan meraih penghargaan Bronze Medal.</p><p>Pencapaian ini membuktikan bahwa mahasiswa kesehatan juga memiliki ketertarikan dan kemampuan di bidang sains yang luas, tidak hanya terbatas pada bidang kesehatan semata.</p>',
                'excerpt' => 'Prestasi membanggakan mahasiswa di kompetisi astronomi tingkat internasional',
                'category_id' => 3,
                'views' => rand(100, 300),
                'published_at' => now()->subDays(rand(1, 7)),
            ],
            [
                'title' => 'Bandung Sustainability Summit 2025, Langkah Bersama Menuju Kota yang Lebih Hijau dan Berkelanjutan',
                'content' => '<p>Kota Bandung menjadi tuan rumah Bandung Sustainability Summit 2025 yang menghadirkan para pemangku kepentingan dari berbagai sektor untuk membahas isu keberlanjutan kota.</p><p>STIKES Karya Bhakti Nusantara Magelang turut berpartisipasi aktif dalam summit ini dengan mengirimkan delegasi dosen dan mahasiswa. Dalam kesempatan tersebut, tim kami mempresentasikan penelitian tentang "Peran Institusi Kesehatan dalam Pembangunan Kota Berkelanjutan".</p><p>Summit ini menjadi ajang berbagi pengalaman dan best practices dalam upaya mewujudkan kota yang lebih hijau, sehat, dan berkelanjutan untuk generasi mendatang.</p>',
                'excerpt' => 'Partisipasi aktif dalam summit keberlanjutan kota di Bandung',
                'category_id' => 2,
                'views' => rand(80, 250),
                'published_at' => now()->subDays(rand(2, 8)),
            ],
            [
                'title' => 'Menko AHY Tutup SIBE 2025: Infrastruktur Berkelanjutan Jadi Katalis Pertumbuhan Ekonomi Indonesia',
                'content' => '<p>Menteri Koordinator Bidang Kemaritiman dan Investasi (Menko Marves) Agus Harimurti Yudhoyono (AHY) menutup acara Sustainable Infrastructure Business Event (SIBE) 2025 di Jakarta Convention Center.</p><p>Dalam sambutannya, Menko AHY menekankan pentingnya pembangunan infrastruktur berkelanjutan sebagai katalis pertumbuhan ekonomi Indonesia. Pembangunan infrastruktur tidak hanya fokus pada aspek fisik, namun juga harus memperhatikan keberlanjutan lingkungan dan sosial.</p><p>Mahasiswa STIKES Karya Bhakti Nusantara yang hadir dalam acara tersebut mendapatkan wawasan berharga tentang pentingnya integrasi prinsip keberlanjutan dalam setiap sektor pembangunan, termasuk sektor kesehatan.</p>',
                'excerpt' => 'Infrastruktur berkelanjutan sebagai kunci pertumbuhan ekonomi nasional',
                'category_id' => 2,
                'views' => rand(150, 350),
                'published_at' => now()->subDays(rand(3, 10)),
            ],
            [
                'title' => 'Workshop Praktik Klinik Keperawatan: Meningkatkan Kompetensi Mahasiswa',
                'content' => '<p>STIKES Karya Bhakti Nusantara Magelang mengadakan Workshop Praktik Klinik Keperawatan yang diikuti oleh seluruh mahasiswa tingkat II dan III. Workshop ini bertujuan untuk meningkatkan kompetensi dan keterampilan praktik keperawatan mahasiswa.</p><p>Dalam workshop yang berlangsung selama 3 hari ini, mahasiswa mendapatkan pelatihan langsung dari praktisi keperawatan berpengalaman dari berbagai rumah sakit ternama. Materi yang diajarkan meliputi teknik perawatan luka, pemberian obat, pemasangan infus, hingga komunikasi terapeutik.</p><p>"Workshop seperti ini sangat penting untuk mempersiapkan mahasiswa menghadapi praktik klinik di lapangan," ujar Ketua STIKES dalam sambutannya.</p>',
                'excerpt' => 'Workshop intensif untuk meningkatkan keterampilan praktik mahasiswa keperawatan',
                'category_id' => 2,
                'views' => rand(90, 220),
                'published_at' => now()->subDays(rand(4, 12)),
            ],
            [
                'title' => 'Pengabdian Masyarakat: Pemeriksaan Kesehatan Gratis di Desa Terpencil',
                'content' => '<p>Tim dosen dan mahasiswa STIKES Karya Bhakti Nusantara Magelang melaksanakan kegiatan pengabdian masyarakat berupa pemeriksaan kesehatan gratis di Desa Sukorejo, Kecamatan Candimulyo, Kabupaten Magelang.</p><p>Kegiatan yang berlangsung selama 2 hari ini melayani lebih dari 200 warga yang memeriksakan kesehatan mereka. Layanan yang diberikan meliputi pemeriksaan tekanan darah, gula darah, kolesterol, serta konsultasi kesehatan gratis.</p><p>Selain itu, tim juga memberikan penyuluhan tentang pola hidup sehat, pentingnya olahraga teratur, dan pengelolaan penyakit kronis seperti hipertensi dan diabetes.</p>',
                'excerpt' => 'Layanan kesehatan gratis untuk masyarakat desa terpencil',
                'category_id' => 2,
                'views' => rand(70, 180),
                'published_at' => now()->subDays(rand(5, 14)),
            ],
            [
                'title' => 'Seminar Nasional Keperawatan: Inovasi Pelayanan Kesehatan di Era Digital',
                'content' => '<p>STIKES Karya Bhakti Nusantara Magelang menjadi tuan rumah Seminar Nasional Keperawatan dengan tema "Inovasi Pelayanan Kesehatan di Era Digital" yang dihadiri oleh lebih dari 300 peserta dari seluruh Indonesia.</p><p>Seminar ini menghadirkan pembicara-pembicara kompeten dari berbagai institusi kesehatan terkemuka yang membahas tentang pemanfaatan teknologi digital dalam pelayanan keperawatan, telemedicine, electronic health record, hingga artificial intelligence dalam diagnosis penyakit.</p><p>Acara yang berlangsung di Aula Graha Nusantara ini juga menjadi ajang presentasi hasil penelitian mahasiswa dan dosen di bidang keperawatan dan kesehatan.</p>',
                'excerpt' => 'Seminar nasional membahas inovasi dan teknologi dalam pelayanan kesehatan',
                'category_id' => 2,
                'views' => rand(120, 280),
                'published_at' => now()->subDays(rand(6, 16)),
            ],
            [
                'title' => 'Kerjasama dengan RS Tipe B: Membuka Peluang Praktik Mahasiswa',
                'content' => '<p>STIKES Karya Bhakti Nusantara Magelang menandatangani Memorandum of Understanding (MoU) dengan RS PKU Muhammadiyah Magelang sebagai mitra praktik klinik mahasiswa keperawatan.</p><p>Kerjasama ini membuka peluang lebih luas bagi mahasiswa untuk mendapatkan pengalaman praktik klinik di rumah sakit dengan fasilitas lengkap dan standar pelayanan tinggi.</p><p>"Dengan adanya kerjasama ini, mahasiswa kami akan mendapatkan exposure yang lebih baik terhadap berbagai kasus dan prosedur medis yang akan sangat bermanfaat untuk karir mereka di masa depan," ungkap Kepala Program Studi Keperawatan.</p>',
                'excerpt' => 'Kerjasama strategis untuk meningkatkan kualitas praktik mahasiswa',
                'category_id' => 1,
                'views' => rand(100, 250),
                'published_at' => now()->subDays(rand(7, 18)),
            ],
            [
                'title' => 'Pelatihan Basic Life Support (BLS) untuk Mahasiswa Tingkat I',
                'content' => '<p>Seluruh mahasiswa tingkat I STIKES Karya Bhakti Nusantara Magelang mengikuti Pelatihan Basic Life Support (BLS) yang diselenggarakan oleh Unit Kegiatan Mahasiswa (UKM) Kesehatan bekerjasama dengan Palang Merah Indonesia (PMI) Kota Magelang.</p><p>Pelatihan ini memberikan pengetahuan dan keterampilan dasar dalam memberikan pertolongan pertama pada korban yang mengalami henti jantung dan henti napas. Mahasiswa dilatih melakukan Resusitasi Jantung Paru (RJP), penggunaan Automated External Defibrillator (AED), dan penanganan sumbatan jalan napas.</p><p>Setiap peserta yang lulus ujian praktik akan mendapatkan sertifikat BLS yang berlaku selama 2 tahun.</p>',
                'excerpt' => 'Pelatihan keterampilan pertolongan pertama untuk mahasiswa baru',
                'category_id' => 2,
                'views' => rand(85, 200),
                'published_at' => now()->subDays(rand(8, 20)),
            ],
            [
                'title' => 'Wisuda ke-15: 150 Lulusan Siap Mengabdi untuk Kesehatan Masyarakat',
                'content' => '<p>STIKES Karya Bhakti Nusantara Magelang menyelenggarakan Wisuda ke-15 yang meluluskan 150 mahasiswa Program Studi Diploma III Keperawatan. Acara yang berlangsung di Gedung Graha Nusantara ini dihadiri oleh orangtua wisudawan, civitas akademika, dan tamu undangan.</p><p>Dalam sambutannya, Ketua STIKES menyampaikan bahwa para lulusan harus siap menghadapi tantangan di dunia kerja dengan bekal ilmu dan keterampilan yang telah diperoleh selama menempuh pendidikan.</p><p>"Jadilah tenaga kesehatan yang profesional, kompeten, dan memiliki dedikasi tinggi dalam melayani masyarakat," pesan Ketua STIKES kepada para wisudawan.</p><p>Wisudawan terbaik dengan IPK tertinggi 3.95 diraih oleh Siti Nurjanah yang juga aktif dalam berbagai organisasi kemahasiswaan.</p>',
                'excerpt' => '150 lulusan keperawatan siap berkontribusi untuk kesehatan masyarakat',
                'category_id' => 1,
                'views' => rand(200, 400),
                'published_at' => now()->subDays(rand(1, 3)),
            ],
        ];

        foreach ($dummyNews as $index => $news) {
            \App\Models\News::create([
                'category_id' => $news['category_id'],
                'user_id' => 1,
                'title' => $news['title'],
                'slug' => Str::slug($news['title']),
                'excerpt' => $news['excerpt'],
                'content' => $news['content'],
                'status' => 'published',
                'published_at' => $news['published_at'],
                'views' => $news['views'],
                'is_featured' => $index < 3 ? 1 : 0, // 3 berita pertama jadi featured
            ]);
        }
    }
}
