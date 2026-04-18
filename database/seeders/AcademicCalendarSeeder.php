<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AcademicCalendar;
use Carbon\Carbon;

class AcademicCalendarSeeder extends Seeder
{
    public function run()
    {
        $currentYear = date('Y');
        $academicYear = $currentYear . '/' . ($currentYear + 1);

        // Semester Ganjil (Agustus - Desember)
        $ganjilEvents = [
            [
                'title' => 'Pendaftaran Mahasiswa Baru',
                'description' => 'Periode pendaftaran calon mahasiswa baru untuk tahun akademik baru',
                'start_date' => Carbon::create($currentYear, 6, 1),
                'end_date' => Carbon::create($currentYear, 7, 31),
                'category' => 'registration',
                'color' => '#f39c12'
            ],
            [
                'title' => 'Daftar Ulang Mahasiswa Lama',
                'description' => 'Registrasi ulang untuk mahasiswa lama semester ganjil',
                'start_date' => Carbon::create($currentYear, 7, 15),
                'end_date' => Carbon::create($currentYear, 8, 10),
                'category' => 'registration',
                'color' => '#e67e22'
            ],
            [
                'title' => 'Orientasi Mahasiswa Baru',
                'description' => 'Kegiatan pengenalan kampus dan akademik untuk mahasiswa baru',
                'start_date' => Carbon::create($currentYear, 8, 15),
                'end_date' => Carbon::create($currentYear, 8, 20),
                'category' => 'academic',
                'color' => '#3498db'
            ],
            [
                'title' => 'Perkuliahan Semester Ganjil Dimulai',
                'description' => 'Hari pertama perkuliahan semester ganjil',
                'start_date' => Carbon::create($currentYear, 9, 1),
                'end_date' => null,
                'category' => 'academic',
                'color' => '#2980b9'
            ],
            [
                'title' => 'Ujian Tengah Semester (UTS)',
                'description' => 'Pelaksanaan ujian tengah semester untuk semua mata kuliah',
                'start_date' => Carbon::create($currentYear, 10, 15),
                'end_date' => Carbon::create($currentYear, 10, 20),
                'category' => 'exam',
                'color' => '#e74c3c'
            ],
            [
                'title' => 'Libur Semester Ganjil',
                'description' => 'Masa libur tengah semester',
                'start_date' => Carbon::create($currentYear, 11, 1),
                'end_date' => Carbon::create($currentYear, 11, 7),
                'category' => 'holiday',
                'color' => '#2ecc71'
            ],
            [
                'title' => 'Ujian Akhir Semester (UAS)',
                'description' => 'Pelaksanaan ujian akhir semester untuk semua mata kuliah',
                'start_date' => Carbon::create($currentYear, 12, 10),
                'end_date' => Carbon::create($currentYear, 12, 20),
                'category' => 'exam',
                'color' => '#c0392b'
            ],
            [
                'title' => 'Libur Akhir Semester',
                'description' => 'Libur setelah ujian akhir semester ganjil',
                'start_date' => Carbon::create($currentYear, 12, 25),
                'end_date' => Carbon::create($currentYear + 1, 1, 5),
                'category' => 'holiday',
                'color' => '#27ae60'
            ]
        ];

        foreach ($ganjilEvents as $index => $event) {
            AcademicCalendar::create(array_merge($event, [
                'academic_year' => $academicYear,
                'semester' => 'Ganjil',
                'is_active' => true,
                'order' => $index
            ]));
        }

        // Semester Genap (Februari - Juni)
        $genapEvents = [
            [
                'title' => 'Daftar Ulang Semester Genap',
                'description' => 'Registrasi ulang untuk semua mahasiswa semester genap',
                'start_date' => Carbon::create($currentYear + 1, 1, 10),
                'end_date' => Carbon::create($currentYear + 1, 1, 31),
                'category' => 'registration',
                'color' => '#f39c12'
            ],
            [
                'title' => 'Perkuliahan Semester Genap Dimulai',
                'description' => 'Hari pertama perkuliahan semester genap',
                'start_date' => Carbon::create($currentYear + 1, 2, 1),
                'end_date' => null,
                'category' => 'academic',
                'color' => '#3498db'
            ],
            [
                'title' => 'Ujian Tengah Semester (UTS)',
                'description' => 'Pelaksanaan ujian tengah semester untuk semua mata kuliah',
                'start_date' => Carbon::create($currentYear + 1, 3, 20),
                'end_date' => Carbon::create($currentYear + 1, 3, 25),
                'category' => 'exam',
                'color' => '#e74c3c'
            ],
            [
                'title' => 'Libur Tengah Semester',
                'description' => 'Masa libur tengah semester genap',
                'start_date' => Carbon::create($currentYear + 1, 4, 1),
                'end_date' => Carbon::create($currentYear + 1, 4, 7),
                'category' => 'holiday',
                'color' => '#2ecc71'
            ],
            [
                'title' => 'Ujian Akhir Semester (UAS)',
                'description' => 'Pelaksanaan ujian akhir semester untuk semua mata kuliah',
                'start_date' => Carbon::create($currentYear + 1, 6, 5),
                'end_date' => Carbon::create($currentYear + 1, 6, 15),
                'category' => 'exam',
                'color' => '#c0392b'
            ],
            [
                'title' => 'Wisuda',
                'description' => 'Upacara wisuda untuk lulusan tahun akademik ini',
                'start_date' => Carbon::create($currentYear + 1, 7, 10),
                'end_date' => Carbon::create($currentYear + 1, 7, 12),
                'category' => 'academic',
                'color' => '#9b59b6'
            ],
            [
                'title' => 'Libur Akhir Tahun Akademik',
                'description' => 'Libur setelah ujian akhir semester genap',
                'start_date' => Carbon::create($currentYear + 1, 7, 15),
                'end_date' => Carbon::create($currentYear + 1, 8, 14),
                'category' => 'holiday',
                'color' => '#27ae60'
            ]
        ];

        foreach ($genapEvents as $index => $event) {
            AcademicCalendar::create(array_merge($event, [
                'academic_year' => $academicYear,
                'semester' => 'Genap',
                'is_active' => true,
                'order' => $index + 100 // Offset untuk semester genap
            ]));
        }

        $this->command->info('Academic Calendar seeder completed!');
        $this->command->info('Created ' . (count($ganjilEvents) + count($genapEvents)) . ' events for ' . $academicYear);
    }
}
