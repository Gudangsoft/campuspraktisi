<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Top Bar Menus
        $topbar = [
            ['title' => 'Staf', 'url' => '/staf', 'order' => 1],
            ['title' => 'Mahasiswa', 'url' => '/mahasiswa', 'order' => 2],
            ['title' => 'Alumni', 'url' => '/alumni', 'order' => 3],
            ['title' => 'Mitra', 'url' => '/mitra', 'order' => 4],
            ['title' => 'Pengunjung', 'url' => '/pengunjung', 'order' => 5],
            ['title' => 'Pers', 'url' => '/pers', 'order' => 6],
            ['title' => 'My Campus', 'url' => '/portal', 'order' => 7, 'target' => '_blank'],
            ['title' => 'Admission', 'url' => '/admission', 'order' => 8],
        ];

        foreach ($topbar as $menu) {
            \App\Models\Menu::create(array_merge($menu, [
                'menu_group' => 'topbar',
                'is_active' => true,
                'target' => $menu['target'] ?? '_self',
            ]));
        }

        // Main Navigation Menus
        $mainMenus = [
            [
                'title' => 'Tentang',
                'url' => '',
                'order' => 1,
                'children' => [
                    ['title' => 'Profil', 'url' => '/profil', 'order' => 1],
                    ['title' => 'Visi & Misi', 'url' => '/visi-misi', 'order' => 2],
                    ['title' => 'Sejarah', 'url' => '/sejarah', 'order' => 3],
                    ['title' => 'Organisasi', 'url' => '/organisasi', 'order' => 4],
                ]
            ],
            [
                'title' => 'Penerimaan',
                'url' => '/penerimaan',
                'order' => 2,
            ],
            [
                'title' => 'Pendidikan',
                'url' => '',
                'order' => 3,
                'children' => [
                    ['title' => 'Program Sarjana', 'url' => '/sarjana', 'order' => 1],
                    ['title' => 'Program Magister', 'url' => '/magister', 'order' => 2],
                    ['title' => 'Program Doktor', 'url' => '/doktor', 'order' => 3],
                ]
            ],
            [
                'title' => 'Penelitian',
                'url' => '/penelitian',
                'order' => 4,
            ],
            [
                'title' => 'Pengabdian',
                'url' => '/pengabdian',
                'order' => 5,
            ],
            [
                'title' => 'Penghargaan',
                'url' => '/penghargaan',
                'order' => 6,
            ],
            [
                'title' => 'Multikampus',
                'url' => '/multikampus',
                'order' => 7,
            ],
        ];

        foreach ($mainMenus as $menu) {
            $parent = \App\Models\Menu::create([
                'title' => $menu['title'],
                'url' => $menu['url'],
                'order' => $menu['order'],
                'menu_group' => 'main',
                'is_active' => true,
                'target' => '_self',
            ]);

            if (isset($menu['children'])) {
                foreach ($menu['children'] as $child) {
                    \App\Models\Menu::create([
                        'title' => $child['title'],
                        'url' => $child['url'],
                        'parent_id' => $parent->id,
                        'order' => $child['order'],
                        'menu_group' => 'main',
                        'is_active' => true,
                        'target' => '_self',
                    ]);
                }
            }
        }
    }
}
