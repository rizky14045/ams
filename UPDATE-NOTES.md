## Update Fitur Approval Checkout

* Tambahkan kolom `approved_at` dan `approved_by` di table `checkout_extracomptable`.
* Tambahkan kolom `approved_at` dan `approved_by` di table `checkout_inventory`.
* Tambahkan kolom `approved_at` dan `approved_by` di table `checkout_aktiva_tetap`.

```sql
ALTER TABLE `checkout_extracomptable` ADD `approved_at` DATETIME NULL DEFAULT NULL AFTER `deleted_at`, ADD `approved_by` INT UNSIGNED NULL DEFAULT NULL AFTER `approved_at`;
ALTER TABLE `checkout_inventory` ADD `approved_at` DATETIME NULL DEFAULT NULL AFTER `deleted_at`, ADD `approved_by` INT UNSIGNED NULL DEFAULT NULL AFTER `approved_at`;
ALTER TABLE `checkout_aktiva_tetap` ADD `approved_at` DATETIME NULL DEFAULT NULL AFTER `deleted_at`, ADD `approved_by` INT UNSIGNED NULL DEFAULT NULL AFTER `approved_at`;
```

## POS Inventory & POS Checkout Inventory

* Tambahkan kolom `is_gudang` di table `ruang`. `ALTER TABLE ruang ADD is_gudang TINYINT(1) DEFAULT 0`.
* Tambahkan Menu POS Inventory didalam menu Asset Inventory
* Tambahkan Menu POS Checkout Inventory didalam menu Asset Inventory

## Log Asset

* Tambahkan table `log_asset_extracomptable`
* Tambahkan table `log_asset_aktiva_tetap`
* Tambahkan table `log_asset_inventory`

## NIK Karyawan

* Tambahkan field `id_karyawan` di table `cms_users`
