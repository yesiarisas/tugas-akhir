<?php

namespace Database\Seeders;

use Dcat\Admin\Models;
use Illuminate\Database\Seeder;
use DB;

class AdminTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // base tables
        Models\Menu::truncate();
        Models\Menu::insert(
            [
                [
                    "id" => 1,
                    "parent_id" => 0,
                    "order" => 1,
                    "title" => "Dashboard",
                    "icon" => "feather icon-bar-chart-2",
                    "uri" => "/",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 16:19:11"
                ],
                [
                    "id" => 2,
                    "parent_id" => 0,
                    "order" => 14,
                    "title" => "Admin",
                    "icon" => "feather icon-settings",
                    "uri" => NULL,
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 3,
                    "parent_id" => 2,
                    "order" => 15,
                    "title" => "Users",
                    "icon" => "",
                    "uri" => "auth/users",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 4,
                    "parent_id" => 2,
                    "order" => 16,
                    "title" => "Roles",
                    "icon" => "",
                    "uri" => "auth/roles",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 5,
                    "parent_id" => 2,
                    "order" => 17,
                    "title" => "Permission",
                    "icon" => "",
                    "uri" => "auth/permissions",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 6,
                    "parent_id" => 2,
                    "order" => 18,
                    "title" => "Menu",
                    "icon" => "",
                    "uri" => "auth/menu",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 7,
                    "parent_id" => 2,
                    "order" => 19,
                    "title" => "Extensions",
                    "icon" => "",
                    "uri" => "auth/extensions",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 18,
                    "parent_id" => 0,
                    "order" => 9,
                    "title" => "Data Anggota",
                    "icon" => "feather icon-users",
                    "uri" => "anggota",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 19,
                    "parent_id" => 0,
                    "order" => 7,
                    "title" => "Kategori Latihan",
                    "icon" => "feather icon-grid",
                    "uri" => "kategori_latihan",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 20,
                    "parent_id" => 0,
                    "order" => 8,
                    "title" => "Pendaftar",
                    "icon" => "feather icon-user-plus",
                    "uri" => "pendaftar",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 21,
                    "parent_id" => 0,
                    "order" => 12,
                    "title" => "Jadwal Latihan",
                    "icon" => "feather icon-calendar",
                    "uri" => "jadwal-latihan",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 22,
                    "parent_id" => 0,
                    "order" => 10,
                    "title" => "Pembayaran",
                    "icon" => "feather icon-credit-card",
                    "uri" => "pembayaran",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 23,
                    "parent_id" => 0,
                    "order" => 13,
                    "title" => "Pengumuman",
                    "icon" => "feather icon-volume-2",
                    "uri" => "pengumuman",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 24,
                    "parent_id" => 0,
                    "order" => 11,
                    "title" => "Perkembangan Anggota",
                    "icon" => "feather icon-bar-chart-2",
                    "uri" => "evaluasi",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 25,
                    "parent_id" => 29,
                    "order" => 3,
                    "title" => "Homepage",
                    "icon" => NULL,
                    "uri" => "homepage",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 26,
                    "parent_id" => 29,
                    "order" => 4,
                    "title" => "Agenda",
                    "icon" => NULL,
                    "uri" => "agenda",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 27,
                    "parent_id" => 29,
                    "order" => 5,
                    "title" => "Info Lomba",
                    "icon" => NULL,
                    "uri" => "infolomba",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 28,
                    "parent_id" => 29,
                    "order" => 6,
                    "title" => "Galeri Prestasi",
                    "icon" => NULL,
                    "uri" => "galeri-prestasi",
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 23:12:45",
                    "updated_at" => "2026-05-20 17:01:46"
                ],
                [
                    "id" => 29,
                    "parent_id" => 0,
                    "order" => 2,
                    "title" => "Halaman",
                    "icon" => "feather icon-home",
                    "uri" => NULL,
                    "extension" => "",
                    "show" => 1,
                    "created_at" => "2026-05-20 16:58:14",
                    "updated_at" => "2026-05-20 17:01:46"
                ]
            ]
        );

        Models\Permission::truncate();
        Models\Permission::insert(
            [
                [
                    "id" => 1,
                    "name" => "Auth management",
                    "slug" => "auth-management",
                    "http_method" => "",
                    "http_path" => "",
                    "order" => 1,
                    "parent_id" => 0,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => NULL
                ],
                [
                    "id" => 2,
                    "name" => "Users",
                    "slug" => "users",
                    "http_method" => "",
                    "http_path" => "/auth/users*",
                    "order" => 2,
                    "parent_id" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => NULL
                ],
                [
                    "id" => 3,
                    "name" => "Roles",
                    "slug" => "roles",
                    "http_method" => "",
                    "http_path" => "/auth/roles*",
                    "order" => 3,
                    "parent_id" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => NULL
                ],
                [
                    "id" => 4,
                    "name" => "Permissions",
                    "slug" => "permissions",
                    "http_method" => "",
                    "http_path" => "/auth/permissions*",
                    "order" => 4,
                    "parent_id" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => NULL
                ],
                [
                    "id" => 5,
                    "name" => "Menu",
                    "slug" => "menu",
                    "http_method" => "",
                    "http_path" => "/auth/menu*",
                    "order" => 5,
                    "parent_id" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => NULL
                ],
                [
                    "id" => 6,
                    "name" => "Extension",
                    "slug" => "extension",
                    "http_method" => "",
                    "http_path" => "/auth/extensions*",
                    "order" => 6,
                    "parent_id" => 1,
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => NULL
                ],
                [
                    "id" => 7,
                    "name" => "evaluasi",
                    "slug" => "evaluasi",
                    "http_method" => "GET,POST,PUT,DELETE,PATCH,OPTIONS",
                    "http_path" => "/evaluasi*,/evaluasi/create,/evaluasi/*/edit,/evaluasi/riwayat/*,/evaluasi/grafik/*",
                    "order" => 7,
                    "parent_id" => 0,
                    "created_at" => "2026-05-20 16:15:41",
                    "updated_at" => "2026-05-20 16:15:41"
                ]
            ]
        );

        Models\Role::truncate();
        Models\Role::insert(
            [
                [
                    "id" => 1,
                    "name" => "Administrator",
                    "slug" => "administrator",
                    "created_at" => "2026-05-20 15:57:20",
                    "updated_at" => "2026-05-20 15:57:20"
                ],
                [
                    "id" => 2,
                    "name" => "Pelatih",
                    "slug" => "Pelatih",
                    "created_at" => "2026-05-20 16:16:09",
                    "updated_at" => "2026-05-20 16:16:09"
                ]
            ]
        );

        Models\Setting::truncate();
		Models\Setting::insert(
			[

            ]
		);

		Models\Extension::truncate();
		Models\Extension::insert(
			[

            ]
		);

		Models\ExtensionHistory::truncate();
		Models\ExtensionHistory::insert(
			[

            ]
		);

        // pivot tables
        DB::table('admin_permission_menu')->truncate();
		DB::table('admin_permission_menu')->insert(
			[
                [
                    "permission_id" => 7,
                    "menu_id" => 24,
                    "created_at" => "2026-05-20 16:15:41",
                    "updated_at" => "2026-05-20 16:15:41"
                ]
            ]
		);

        DB::table('admin_role_menu')->truncate();
        DB::table('admin_role_menu')->insert(
            [
                [
                    "role_id" => 1,
                    "menu_id" => 2,
                    "created_at" => "2026-05-20 16:19:21",
                    "updated_at" => "2026-05-20 16:19:21"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 18,
                    "created_at" => "2026-05-20 16:17:25",
                    "updated_at" => "2026-05-20 16:17:25"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 19,
                    "created_at" => "2026-05-20 16:19:41",
                    "updated_at" => "2026-05-20 16:19:41"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 20,
                    "created_at" => "2026-05-20 16:17:44",
                    "updated_at" => "2026-05-20 16:17:44"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 21,
                    "created_at" => "2026-05-20 16:17:55",
                    "updated_at" => "2026-05-20 16:17:55"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 22,
                    "created_at" => "2026-05-20 16:18:04",
                    "updated_at" => "2026-05-20 16:18:04"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 23,
                    "created_at" => "2026-05-20 16:18:11",
                    "updated_at" => "2026-05-20 16:18:11"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 24,
                    "created_at" => "2026-05-20 16:17:15",
                    "updated_at" => "2026-05-20 16:17:15"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 25,
                    "created_at" => "2026-05-20 16:18:18",
                    "updated_at" => "2026-05-20 16:18:18"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 26,
                    "created_at" => "2026-05-20 16:18:28",
                    "updated_at" => "2026-05-20 16:18:28"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 27,
                    "created_at" => "2026-05-20 16:18:35",
                    "updated_at" => "2026-05-20 16:18:35"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 28,
                    "created_at" => "2026-05-20 16:18:42",
                    "updated_at" => "2026-05-20 16:18:42"
                ],
                [
                    "role_id" => 1,
                    "menu_id" => 29,
                    "created_at" => "2026-06-08 02:41:39",
                    "updated_at" => "2026-06-08 02:41:39"
                ],
                [
                    "role_id" => 2,
                    "menu_id" => 24,
                    "created_at" => "2026-05-20 16:16:09",
                    "updated_at" => "2026-05-20 16:16:09"
                ]
            ]
        );

        DB::table('admin_role_permissions')->truncate();
        DB::table('admin_role_permissions')->insert(
            [
                [
                    "role_id" => 2,
                    "permission_id" => 7,
                    "created_at" => "2026-05-20 16:30:22",
                    "updated_at" => "2026-05-20 16:30:22"
                ]
            ]
        );

        // finish
    }
}
