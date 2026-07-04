<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection is_enabled
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection type
     * @property Grid\Column|Collection detail
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection extension
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection value
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection judul
     * @property Grid\Column|Collection tanggal
     * @property Grid\Column|Collection lokasi
     * @property Grid\Column|Collection deskripsi
     * @property Grid\Column|Collection gambar
     * @property Grid\Column|Collection kategori_id
     * @property Grid\Column|Collection nama
     * @property Grid\Column|Collection tanggal_lahir
     * @property Grid\Column|Collection no_hp
     * @property Grid\Column|Collection alamat
     * @property Grid\Column|Collection tanggal_gabung
     * @property Grid\Column|Collection anggota_id
     * @property Grid\Column|Collection tanggal_evaluasi
     * @property Grid\Column|Collection nilai_teknik
     * @property Grid\Column|Collection nilai_kedisiplinan
     * @property Grid\Column|Collection nilai_kehadiran
     * @property Grid\Column|Collection catatan
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection logo
     * @property Grid\Column|Collection nama_sanggar
     * @property Grid\Column|Collection hero_title
     * @property Grid\Column|Collection hero_subtitle
     * @property Grid\Column|Collection hero_image
     * @property Grid\Column|Collection hero_button_text
     * @property Grid\Column|Collection hero_button_link
     * @property Grid\Column|Collection kategori1_nama
     * @property Grid\Column|Collection kategori1_deskripsi
     * @property Grid\Column|Collection kategori1_gambar
     * @property Grid\Column|Collection kategori2_nama
     * @property Grid\Column|Collection kategori2_deskripsi
     * @property Grid\Column|Collection kategori2_gambar
     * @property Grid\Column|Collection tentang_judul
     * @property Grid\Column|Collection tentang_deskripsi
     * @property Grid\Column|Collection tentang_gambar
     * @property Grid\Column|Collection footer_deskripsi
     * @property Grid\Column|Collection footer_telepon
     * @property Grid\Column|Collection footer_alamat
     * @property Grid\Column|Collection hari
     * @property Grid\Column|Collection jam_mulai
     * @property Grid\Column|Collection jam_selesai
     * @property Grid\Column|Collection keterangan
     * @property Grid\Column|Collection status
     * @property Grid\Column|Collection nama_kategori
     * @property Grid\Column|Collection is_active
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection jenis
     * @property Grid\Column|Collection periode
     * @property Grid\Column|Collection nominal
     * @property Grid\Column|Collection tanggal_bayar
     * @property Grid\Column|Collection nama_pendaftar
     * @property Grid\Column|Collection tanggal_daftar
     * @property Grid\Column|Collection catatan_admin
     * @property Grid\Column|Collection isi
     * @property Grid\Column|Collection tokenable_type
     * @property Grid\Column|Collection tokenable_id
     * @property Grid\Column|Collection abilities
     * @property Grid\Column|Collection last_used_at
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection is_enabled(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection type(string $label = null)
     * @method Grid\Column|Collection detail(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection extension(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection value(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection judul(string $label = null)
     * @method Grid\Column|Collection tanggal(string $label = null)
     * @method Grid\Column|Collection lokasi(string $label = null)
     * @method Grid\Column|Collection deskripsi(string $label = null)
     * @method Grid\Column|Collection gambar(string $label = null)
     * @method Grid\Column|Collection kategori_id(string $label = null)
     * @method Grid\Column|Collection nama(string $label = null)
     * @method Grid\Column|Collection tanggal_lahir(string $label = null)
     * @method Grid\Column|Collection no_hp(string $label = null)
     * @method Grid\Column|Collection alamat(string $label = null)
     * @method Grid\Column|Collection tanggal_gabung(string $label = null)
     * @method Grid\Column|Collection anggota_id(string $label = null)
     * @method Grid\Column|Collection tanggal_evaluasi(string $label = null)
     * @method Grid\Column|Collection nilai_teknik(string $label = null)
     * @method Grid\Column|Collection nilai_kedisiplinan(string $label = null)
     * @method Grid\Column|Collection nilai_kehadiran(string $label = null)
     * @method Grid\Column|Collection catatan(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection logo(string $label = null)
     * @method Grid\Column|Collection nama_sanggar(string $label = null)
     * @method Grid\Column|Collection hero_title(string $label = null)
     * @method Grid\Column|Collection hero_subtitle(string $label = null)
     * @method Grid\Column|Collection hero_image(string $label = null)
     * @method Grid\Column|Collection hero_button_text(string $label = null)
     * @method Grid\Column|Collection hero_button_link(string $label = null)
     * @method Grid\Column|Collection kategori1_nama(string $label = null)
     * @method Grid\Column|Collection kategori1_deskripsi(string $label = null)
     * @method Grid\Column|Collection kategori1_gambar(string $label = null)
     * @method Grid\Column|Collection kategori2_nama(string $label = null)
     * @method Grid\Column|Collection kategori2_deskripsi(string $label = null)
     * @method Grid\Column|Collection kategori2_gambar(string $label = null)
     * @method Grid\Column|Collection tentang_judul(string $label = null)
     * @method Grid\Column|Collection tentang_deskripsi(string $label = null)
     * @method Grid\Column|Collection tentang_gambar(string $label = null)
     * @method Grid\Column|Collection footer_deskripsi(string $label = null)
     * @method Grid\Column|Collection footer_telepon(string $label = null)
     * @method Grid\Column|Collection footer_alamat(string $label = null)
     * @method Grid\Column|Collection hari(string $label = null)
     * @method Grid\Column|Collection jam_mulai(string $label = null)
     * @method Grid\Column|Collection jam_selesai(string $label = null)
     * @method Grid\Column|Collection keterangan(string $label = null)
     * @method Grid\Column|Collection status(string $label = null)
     * @method Grid\Column|Collection nama_kategori(string $label = null)
     * @method Grid\Column|Collection is_active(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection jenis(string $label = null)
     * @method Grid\Column|Collection periode(string $label = null)
     * @method Grid\Column|Collection nominal(string $label = null)
     * @method Grid\Column|Collection tanggal_bayar(string $label = null)
     * @method Grid\Column|Collection nama_pendaftar(string $label = null)
     * @method Grid\Column|Collection tanggal_daftar(string $label = null)
     * @method Grid\Column|Collection catatan_admin(string $label = null)
     * @method Grid\Column|Collection isi(string $label = null)
     * @method Grid\Column|Collection tokenable_type(string $label = null)
     * @method Grid\Column|Collection tokenable_id(string $label = null)
     * @method Grid\Column|Collection abilities(string $label = null)
     * @method Grid\Column|Collection last_used_at(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection id
     * @property Show\Field|Collection name
     * @property Show\Field|Collection version
     * @property Show\Field|Collection is_enabled
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection type
     * @property Show\Field|Collection detail
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection extension
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection value
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection judul
     * @property Show\Field|Collection tanggal
     * @property Show\Field|Collection lokasi
     * @property Show\Field|Collection deskripsi
     * @property Show\Field|Collection gambar
     * @property Show\Field|Collection kategori_id
     * @property Show\Field|Collection nama
     * @property Show\Field|Collection tanggal_lahir
     * @property Show\Field|Collection no_hp
     * @property Show\Field|Collection alamat
     * @property Show\Field|Collection tanggal_gabung
     * @property Show\Field|Collection anggota_id
     * @property Show\Field|Collection tanggal_evaluasi
     * @property Show\Field|Collection nilai_teknik
     * @property Show\Field|Collection nilai_kedisiplinan
     * @property Show\Field|Collection nilai_kehadiran
     * @property Show\Field|Collection catatan
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection logo
     * @property Show\Field|Collection nama_sanggar
     * @property Show\Field|Collection hero_title
     * @property Show\Field|Collection hero_subtitle
     * @property Show\Field|Collection hero_image
     * @property Show\Field|Collection hero_button_text
     * @property Show\Field|Collection hero_button_link
     * @property Show\Field|Collection kategori1_nama
     * @property Show\Field|Collection kategori1_deskripsi
     * @property Show\Field|Collection kategori1_gambar
     * @property Show\Field|Collection kategori2_nama
     * @property Show\Field|Collection kategori2_deskripsi
     * @property Show\Field|Collection kategori2_gambar
     * @property Show\Field|Collection tentang_judul
     * @property Show\Field|Collection tentang_deskripsi
     * @property Show\Field|Collection tentang_gambar
     * @property Show\Field|Collection footer_deskripsi
     * @property Show\Field|Collection footer_telepon
     * @property Show\Field|Collection footer_alamat
     * @property Show\Field|Collection hari
     * @property Show\Field|Collection jam_mulai
     * @property Show\Field|Collection jam_selesai
     * @property Show\Field|Collection keterangan
     * @property Show\Field|Collection status
     * @property Show\Field|Collection nama_kategori
     * @property Show\Field|Collection is_active
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection jenis
     * @property Show\Field|Collection periode
     * @property Show\Field|Collection nominal
     * @property Show\Field|Collection tanggal_bayar
     * @property Show\Field|Collection nama_pendaftar
     * @property Show\Field|Collection tanggal_daftar
     * @property Show\Field|Collection catatan_admin
     * @property Show\Field|Collection isi
     * @property Show\Field|Collection tokenable_type
     * @property Show\Field|Collection tokenable_id
     * @property Show\Field|Collection abilities
     * @property Show\Field|Collection last_used_at
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection is_enabled(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection type(string $label = null)
     * @method Show\Field|Collection detail(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection extension(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection value(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection judul(string $label = null)
     * @method Show\Field|Collection tanggal(string $label = null)
     * @method Show\Field|Collection lokasi(string $label = null)
     * @method Show\Field|Collection deskripsi(string $label = null)
     * @method Show\Field|Collection gambar(string $label = null)
     * @method Show\Field|Collection kategori_id(string $label = null)
     * @method Show\Field|Collection nama(string $label = null)
     * @method Show\Field|Collection tanggal_lahir(string $label = null)
     * @method Show\Field|Collection no_hp(string $label = null)
     * @method Show\Field|Collection alamat(string $label = null)
     * @method Show\Field|Collection tanggal_gabung(string $label = null)
     * @method Show\Field|Collection anggota_id(string $label = null)
     * @method Show\Field|Collection tanggal_evaluasi(string $label = null)
     * @method Show\Field|Collection nilai_teknik(string $label = null)
     * @method Show\Field|Collection nilai_kedisiplinan(string $label = null)
     * @method Show\Field|Collection nilai_kehadiran(string $label = null)
     * @method Show\Field|Collection catatan(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection logo(string $label = null)
     * @method Show\Field|Collection nama_sanggar(string $label = null)
     * @method Show\Field|Collection hero_title(string $label = null)
     * @method Show\Field|Collection hero_subtitle(string $label = null)
     * @method Show\Field|Collection hero_image(string $label = null)
     * @method Show\Field|Collection hero_button_text(string $label = null)
     * @method Show\Field|Collection hero_button_link(string $label = null)
     * @method Show\Field|Collection kategori1_nama(string $label = null)
     * @method Show\Field|Collection kategori1_deskripsi(string $label = null)
     * @method Show\Field|Collection kategori1_gambar(string $label = null)
     * @method Show\Field|Collection kategori2_nama(string $label = null)
     * @method Show\Field|Collection kategori2_deskripsi(string $label = null)
     * @method Show\Field|Collection kategori2_gambar(string $label = null)
     * @method Show\Field|Collection tentang_judul(string $label = null)
     * @method Show\Field|Collection tentang_deskripsi(string $label = null)
     * @method Show\Field|Collection tentang_gambar(string $label = null)
     * @method Show\Field|Collection footer_deskripsi(string $label = null)
     * @method Show\Field|Collection footer_telepon(string $label = null)
     * @method Show\Field|Collection footer_alamat(string $label = null)
     * @method Show\Field|Collection hari(string $label = null)
     * @method Show\Field|Collection jam_mulai(string $label = null)
     * @method Show\Field|Collection jam_selesai(string $label = null)
     * @method Show\Field|Collection keterangan(string $label = null)
     * @method Show\Field|Collection status(string $label = null)
     * @method Show\Field|Collection nama_kategori(string $label = null)
     * @method Show\Field|Collection is_active(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection jenis(string $label = null)
     * @method Show\Field|Collection periode(string $label = null)
     * @method Show\Field|Collection nominal(string $label = null)
     * @method Show\Field|Collection tanggal_bayar(string $label = null)
     * @method Show\Field|Collection nama_pendaftar(string $label = null)
     * @method Show\Field|Collection tanggal_daftar(string $label = null)
     * @method Show\Field|Collection catatan_admin(string $label = null)
     * @method Show\Field|Collection isi(string $label = null)
     * @method Show\Field|Collection tokenable_type(string $label = null)
     * @method Show\Field|Collection tokenable_id(string $label = null)
     * @method Show\Field|Collection abilities(string $label = null)
     * @method Show\Field|Collection last_used_at(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
