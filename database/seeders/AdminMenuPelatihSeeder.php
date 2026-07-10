<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminMenuPelatihSeeder extends Seeder
{
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // 1. Cleanup old data (Garda keamanan agar tidak duplikat)
        DB::table('admin_menu')->whereIn('id', [18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29])->delete();
        DB::table('admin_permissions')->where('id', 7)->delete();
        DB::table('admin_roles')->whereIn('id', [1, 2])->delete();
        DB::table('admin_users')->whereIn('id', [1, 2])->delete();
        
        DB::table('admin_role_menu')->where('menu_id', '>=', 18)->orWhereIn('role_id', [1, 2])->delete();
        DB::table('admin_role_permissions')->whereIn('role_id', [1, 2])->orWhere('permission_id', 7)->delete();
        DB::table('admin_permission_menu')->where('permission_id', 7)->orWhere('menu_id', 24)->delete();
        DB::table('admin_role_users')->whereIn('user_id', [1, 2])->delete();

        // 2. Seed: Menus
        DB::table('admin_menu')->insert([
            ['id' => 18, 'parent_id' => 0, 'order' => 9, 'title' => 'Data Anggota', 'icon' => 'feather icon-users', 'uri' => 'anggota', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 19, 'parent_id' => 0, 'order' => 7, 'title' => 'Kategori Latihan', 'icon' => 'feather icon-grid', 'uri' => 'kategori_latihan', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 20, 'parent_id' => 0, 'order' => 8, 'title' => 'Pendaftar', 'icon' => 'feather icon-user-plus', 'uri' => 'pendaftar', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 21, 'parent_id' => 0, 'order' => 12, 'title' => 'Jadwal Latihan', 'icon' => 'feather icon-calendar', 'uri' => 'jadwal-latihan', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 22, 'parent_id' => 0, 'order' => 10, 'title' => 'Pembayaran', 'icon' => 'feather icon-credit-card', 'uri' => 'pembayaran', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 23, 'parent_id' => 0, 'order' => 13, 'title' => 'Pengumuman', 'icon' => 'feather icon-volume-2', 'uri' => 'pengumuman', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 24, 'parent_id' => 0, 'order' => 11, 'title' => 'Perkembangan Anggota', 'icon' => 'feather icon-bar-chart-2', 'uri' => 'evaluasi', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 29, 'parent_id' => 0, 'order' => 2, 'title' => 'Halaman', 'icon' => 'feather icon-home', 'uri' => null, 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 16:58:14', 'updated_at' => '2026-05-20 17:01:46'],
            
            ['id' => 25, 'parent_id' => 29, 'order' => 3, 'title' => 'Homepage', 'icon' => null, 'uri' => 'homepage', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 26, 'parent_id' => 29, 'order' => 4, 'title' => 'Agenda', 'icon' => null, 'uri' => 'agenda', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 27, 'parent_id' => 29, 'order' => 5, 'title' => 'Info Lomba', 'icon' => null, 'uri' => 'infolomba', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46'],
            ['id' => 28, 'parent_id' => 29, 'order' => 6, 'title' => 'Galeri Prestasi', 'icon' => null, 'uri' => 'galeri-prestasi', 'extension' => '', 'show' => 1, 'created_at' => '2026-05-20 23:12:45', 'updated_at' => '2026-05-20 17:01:46']
        ]);

        // 3. Seed: Permissions
        DB::table('admin_permissions')->insert([
            ['id' => 7, 'name' => 'evaluasi', 'slug' => 'evaluasi', 'http_method' => 'GET,POST,PUT,DELETE,PATCH,OPTIONS', 'http_path' => '/evaluasi*,/evaluasi/create,/evaluasi/*/edit,/evaluasi/riwayat/*,/evaluasi/grafik/*', 'order' => 7, 'parent_id' => 0, 'created_at' => '2026-05-20 16:15:41', 'updated_at' => '2026-05-20 16:15:41']
        ]);

        // 4. Seed: Roles (Administrator dan Pelatih)
        DB::table('admin_roles')->insert([
            ['id' => 1, 'name' => 'Administrator', 'slug' => 'administrator', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Pelatih', 'slug' => 'Pelatih', 'created_at' => '2026-05-20 16:16:09', 'updated_at' => '2026-05-20 16:16:09']
        ]);

        // 5. Seed: Users (Otomatis Admin ID 1 dan Pelatih ID 2)
        DB::table('admin_users')->insert([
            [
                'id' => 1,
                'username' => 'admin',
                'password' => bcrypt('admin'),
                'name' => 'Administrator',
                'avatar' => null,
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'username' => 'pelatih',
                'password' => '$2y$10$GCL8jtjy9dpJPSRCZhQ6MuuPUsbGwhiiWCRjvwhR7D6.xwoS3l5Pu',
                'name' => 'Pelatih',
                'avatar' => null,
                'remember_token' => null,
                'created_at' => '2026-07-09 09:07:14',
                'updated_at' => '2026-07-09 09:07:14',
            ]
        ]);

        // 6. Relations: User to Role
        DB::table('admin_role_users')->insert([
            ['role_id' => 1, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'user_id' => 2, 'created_at' => '2026-07-09 09:07:14', 'updated_at' => '2026-07-09 09:07:14']
        ]);

        // 7. Relations: Role to Permission
        DB::table('admin_role_permissions')->insert([
            ['role_id' => 2, 'permission_id' => 7, 'created_at' => '2026-05-20 16:30:22', 'updated_at' => '2026-05-20 16:30:22']
        ]);

        // 8. Relations: Permission to Menu
        DB::table('admin_permission_menu')->insert([
            ['permission_id' => 7, 'menu_id' => 24, 'created_at' => '2026-05-20 16:15:41', 'updated_at' => '2026-05-20 16:15:41']
        ]);

        // 9. Relations: Role to Menu
        DB::table('admin_role_menu')->insert([
            ['role_id' => 1, 'menu_id' => 18, 'created_at' => '2026-05-20 16:17:25', 'updated_at' => '2026-05-20 16:17:25'],
            ['role_id' => 1, 'menu_id' => 19, 'created_at' => '2026-05-20 16:19:41', 'updated_at' => '2026-05-20 16:19:41'],
            ['role_id' => 1, 'menu_id' => 20, 'created_at' => '2026-05-20 16:17:44', 'updated_at' => '2026-05-20 16:17:44'],
            ['role_id' => 1, 'menu_id' => 21, 'created_at' => '2026-05-20 16:17:55', 'updated_at' => '2026-05-20 16:17:55'],
            ['role_id' => 1, 'menu_id' => 22, 'created_at' => '2026-05-20 16:18:04', 'updated_at' => '2026-05-20 16:18:04'],
            ['role_id' => 1, 'menu_id' => 23, 'created_at' => '2026-05-20 16:18:11', 'updated_at' => '2026-05-20 16:18:11'],
            ['role_id' => 1, 'menu_id' => 24, 'created_at' => '2026-05-20 16:17:15', 'updated_at' => '2026-05-20 16:17:15'],
            ['role_id' => 1, 'menu_id' => 25, 'created_at' => '2026-05-20 16:18:18', 'updated_at' => '2026-05-20 16:18:18'],
            ['role_id' => 1, 'menu_id' => 26, 'created_at' => '2026-05-20 16:18:28', 'updated_at' => '2026-05-20 16:18:28'],
            ['role_id' => 1, 'menu_id' => 27, 'created_at' => '2026-05-20 16:18:35', 'updated_at' => '2026-05-20 16:18:35'],
            ['role_id' => 1, 'menu_id' => 28, 'created_at' => '2026-05-20 16:18:42', 'updated_at' => '2026-05-20 16:18:42'],
            ['role_id' => 1, 'menu_id' => 29, 'created_at' => '2026-06-08 02:41:39', 'updated_at' => '2026-06-08 02:41:39'],
            ['role_id' => 2, 'menu_id' => 24, 'created_at' => '2026-05-20 16:16:09', 'updated_at' => '2026-05-20 16:16:09']
        ]);


        DB::table('admin_menu')->where('id', 1)->update([
            'title'      => 'Dashboard',
            'icon'       => 'feather icon-home', // Sesuaikan icon kesukaan Anda
            'updated_at' => now()
        ]);

        Schema::enableForeignKeyConstraints();
    }
}