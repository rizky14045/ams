
CREATE TABLE `jenis_pemeliharaan_aktiva_tetap` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_jenis` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_pemeliharaan_aktiva_tetap`
--

INSERT INTO `jenis_pemeliharaan_aktiva_tetap` (`id`, `nama_jenis`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Buckminster Bass', '2017-11-03 18:47:49', NULL, NULL),
(2, 'Sarah Gallegos', '2017-11-03 18:47:52', NULL, NULL),
(3, 'Kermit Morales', '2017-11-03 18:47:54', NULL, NULL),
(4, 'Kibo Marquez', '2017-11-03 18:47:55', NULL, NULL);


CREATE TABLE `jenis_pemeliharaan_extracomptable` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama_jenis` varchar(120) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jenis_pemeliharaan_aktiva_tetap`
--

INSERT INTO `jenis_pemeliharaan_extracomptable` (`id`, `nama_jenis`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Buckminster Bass', '2017-11-03 18:47:49', NULL, NULL),
(2, 'Sarah Gallegos', '2017-11-03 18:47:52', NULL, NULL),
(3, 'Kermit Morales', '2017-11-03 18:47:54', NULL, NULL),
(4, 'Kibo Marquez', '2017-11-03 18:47:55', NULL, NULL);

