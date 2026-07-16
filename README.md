# AccaFlow: Sistem Pelacakan & Persetujuan Dokumen Akademik

## 📝 Deskripsi Singkat AccaFlow
AccaFlow adalah aplikasi berbasis web yang dirancang khusus untuk memfasilitasi dan melacak alur pengajuan dokumen akademik di lingkungan universitas. Sistem ini menjembatani komunikasi antara Mahasiswa, Admin Program Studi, Ketua Program Studi (Kaprodi), dan Dosen. Dengan AccaFlow, proses pengajuan dokumen seperti surat keterangan aktif, surat magang, dan dokumen akademik lainnya menjadi lebih transparan, terstruktur, dan efisien melalui fitur pelacakan status real-time, pembubuhan stempel digital, hingga penandatanganan dokumen yang dilengkapi dengan verifikasi hash publik.

---

## 🔑 Demo Account
Berikut adalah kredensial akun demo yang dapat digunakan untuk mencoba berbagai hak akses dalam sistem AccaFlow:

| Role | Email | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@accaflow.com` | `password` | Akun Developer (Hanya aktif selama masa pengembangan) yang memiliki akses penuh ke sistem, termasuk manajemen akun dosen, dan penghapusan paksa dokumen. |
| **Admin** | `admin@accaflow.com` | `password` | Mengelola dokumen masuk, melakukan verifikasi awal (Tahap 1), dan mengelola data dosen. |
| **Kaprodi** | `kaprodi@accaflow.com` | `password` | Memberikan persetujuan dan mengunggah dokumen ber-stempel digital prodi (Tahap 2). |
| **Dosen** | `dosen@accaflow.com` | `password` | Menerima pengajuan spesifik, memberikan penandatanganan akhir (Tahap 3). |
| **Mahasiswa** | `student@accaflow.com` | `password` | Mengajukan dokumen baru dan melacak status dokumen secara mandiri. |

> **Catatan:** Semua akun demo menggunakan password standar `password`.

---

## 🧩 Komponen Utama
*   **Modul Autentikasi & RBAC (Role-Based Access Control):** Mengatur 5 level otorisasi pengguna secara aman untuk memastikan data terisolasi dengan benar (misal: dosen hanya melihat dokumennya sendiri).
*   **Manajemen Dosen:** Modul CRUD khusus untuk mengelola profil dosen, meliputi atribut spesifik seperti NIDN/NIP, Jabatan Struktural (Dosen Biasa, Kaprodi, Sekprodi, Dekan), dan email institusi.
*   **Document Engine:** Mesin utama yang menangani unggah (*upload*), penyimpanan lokal (*secure private storage*), dan pengunduhan (*download*) berbagai versi file (Asli, Ber-stempel, dan Ber-tanda tangan).
*   **Activity Logger:** Sistem pencatatan riwayat (Audit Trail) yang merekam setiap aksi secara kronologis (dari terbaru ke terlama), mencatat siapa, kapan, dan tindakan apa yang dilakukan pada dokumen.
*   **Dashboard & Analytics:** Memberikan visualisasi cepat terkait jumlah dokumen yang diajukan, diproses, selesai, serta fitur peringatan otomatis (*Overdue Indicator*) untuk dokumen yang belum diproses lebih dari 2 hari.
*   **Web-Based Document Management:** Systems leveraging web-based platforms ensure centralized and near real-time access to academic documents, improving operational transparency and reducing manual errors [1] [2].
*   **Near Real-Time Document Tracking and Monitoring:** Near Real-time updates and tracking mechanisms, such as those enabled by QR code scanning, allow users to monitor document status efficiently [1] [2]. Dashboards and centralized communication systems provide a comprehensive overview of document workflows [2].
*   **QR Code for Authentication and Integrity:** QR code-based verification is a robust method for ensuring document authenticity and integrity [4] [5]. QR codes enhance security by enabling tamper-proof verification and efficient document sharing [5] [6].

---

## 🧪 Quality Testing Results
Pengujian fungsional dan keamanan sistem telah dilakukan dengan hasil sebagai berikut:

*   **Black Box Testing:**
    *   Pengujian ini dilakukan untuk menjawab rumusan masalah terkait tingginya risiko kesalahan manual (*manual errors*) dan keterlambatan distribusi dokumen dalam sistem konvensional.
    *   Fokus utama *Black Box Testing* adalah memvalidasi fungsi-fungsi dasar sistem seperti pengunggahan berkas, pencarian arsip, dan alur distribusi surat.
*   **Security & Role-Based Access Control (RBAC) Testing:**
    *   Pengujian ini dirumuskan untuk mengatasi masalah kerentanan terhadap akses tidak sah (*unauthorized access*) pada dokumen akademik yang bersifat sensitif.
    *   Skenario pengujian mencakup verifikasi pembatasan akses dan pencegahan penyalahgunaan data, guna menjaga integritas serta keamanan data dokumen dalam struktur organisasi kampus.
*   **QR Code & Integrity Testing:**
    *   Pengujian ini berfokus pada masalah kerentanan manipulasi data digital dan pemalsuan dokumen akademik.
    *   Skenario pengujian melibatkan pemindaian QR Code untuk memastikan bahwa dokumen tersebut asli dan belum dimanipulasi.
*   **User Acceptance Testing (UAT):**
    *   UAT melibatkan pengguna akhir untuk menilai sejauh mana fitur pelacakan *near real-time* melalui dashboard pusat dapat memberikan kemudahan dalam memantau status dokumen secara transparan.
    *   Pengujian ini mengukur tingkat penerimaan pengguna terhadap efisiensi koordinasi dan kemudahan akses informasi yang disediakan oleh sistem dalam mempercepat birokrasi akademik.
