<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Greeting;

class GreetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $greetings = [
            [
                'section_name' => 'Sambutan Direktur',
                'title' => 'Selamat Datang di Akademi Keperawatan',
                'subtitle' => 'Membangun Perawat Profesional dan Berintegritas',
                'content' => 'Assalamualaikum Warahmatullahi Wabarakatuh,

Puji syukur kami panjatkan kepada Allah SWT atas rahmat dan karunia-Nya. Selamat datang di website resmi Akademi Keperawatan Kesdam IV/Diponegoro.

Kami berkomitmen untuk mencetak tenaga kesehatan profesional yang kompeten, berakhlak mulia, dan siap mengabdi kepada bangsa dan negara. Melalui pendidikan berkualitas tinggi dan fasilitas modern, kami mempersiapkan mahasiswa untuk menjadi perawat yang handal dan berdedikasi.

Terima kasih atas kepercayaan Anda kepada institusi kami. Mari bersama-sama membangun masa depan kesehatan Indonesia yang lebih baik.

Wassalamualaikum Warahmatullahi Wabarakatuh',
                'person_name' => 'dr. Ahmad Fauzi, M.Kes',
                'person_title' => 'Direktur Akademi Keperawatan',
                'order' => 1,
                'is_active' => true
            ],
            [
                'section_name' => 'Visi & Misi',
                'title' => 'Menuju Keunggulan dalam Pendidikan Keperawatan',
                'subtitle' => null,
                'content' => 'Visi kami adalah menjadi institusi pendidikan keperawatan terkemuka yang menghasilkan lulusan berkualitas tinggi, profesional, dan berdaya saing global.

Misi kami meliputi:
- Menyelenggarakan pendidikan keperawatan berkualitas sesuai standar nasional dan internasional
- Mengembangkan penelitian dan pengabdian masyarakat di bidang keperawatan
- Membangun kerjasama dengan berbagai institusi kesehatan dalam dan luar negeri
- Menciptakan lingkungan akademik yang kondusif dan inovatif',
                'person_name' => null,
                'person_title' => null,
                'order' => 2,
                'is_active' => true
            ]
        ];

        foreach ($greetings as $greeting) {
            Greeting::create($greeting);
        }
    }
}
