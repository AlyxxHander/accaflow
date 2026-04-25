# AccaFlow: Sistem Pelacakan & Persetujuan Dokumen Akademik

## 📝 Deskripsi Singkat AccaFlow
AccaFlow adalah aplikasi berbasis web yang dirancang khusus untuk memfasilitasi dan melacak alur pengajuan dokumen akademik di lingkungan universitas. Sistem ini menjembatani komunikasi antara Mahasiswa, Admin Program Studi, Ketua Program Studi (Kaprodi), dan Dosen. Dengan AccaFlow, proses pengajuan dokumen seperti surat keterangan aktif, surat magang, dan dokumen akademik lainnya menjadi lebih transparan, terstruktur, dan efisien melalui fitur pelacakan status real-time, pembubuhan stempel digital, hingga penandatanganan dokumen yang dilengkapi dengan verifikasi hash publik.

---

## 🔑 Demo Account
Berikut adalah kredensial akun demo yang dapat digunakan untuk mencoba berbagai hak akses dalam sistem AccaFlow:

| Role | Email | Password | Keterangan |
| :--- | :--- | :--- | :--- |
| **Super Admin** | `superadmin@accaflow.com` | `password` | Akses penuh ke sistem, termasuk manajemen akun dosen dan penghapusan paksa dokumen. |
| **Admin** | `admin@accaflow.com` | `password` | Mengelola dokumen masuk, melakukan verifikasi awal (Tahap 1), dan mengelola data dosen. |
| **Kaprodi** | `kaprodi@accaflow.com` | `password` | Memberikan persetujuan dan mengunggah dokumen ber-stempel digital prodi (Tahap 2). |
| **Dosen** | `dosen@accaflow.com` | `password` | Menerima pengajuan spesifik, memberikan penandatanganan akhir (Tahap 3). |
| **Mahasiswa** | `student@accaflow.com` | `password` | Mengajukan dokumen baru dan melacak status dokumen secara mandiri. |

> **Catatan:** Semua akun demo menggunakan password standar `password`.

---

## ⚙️ Algoritma & Alur Kerja (Workflow)
AccaFlow menggunakan algoritma alur kerja sekuensial (*Sequential Workflow Algorithm*) dengan aturan validasi berbasis peran (Role-Based Access Control).

1. **Inisiasi (Tahap 1 - Diajukan):** Mahasiswa mengunggah dokumen (PDF/Gambar) dan memilih Dosen Tujuan. Sistem secara otomatis mencatat *timestamp* dan membuat *log* awal.
2. **Verifikasi (Tahap 2 - Verifikasi Admin):** Admin mengecek kelengkapan dan keabsahan dokumen. Jika tidak sesuai, dokumen dapat ditolak (Rejected) atau dikembalikan (Reverted). Jika sesuai, status naik ke *Verified*.
3. **Persetujuan (Tahap 3 - Stempel Digital Prodi):** Kaprodi (atau Admin yang memiliki wewenang) mengunggah kembali dokumen yang telah dibubuhi stempel resmi prodi. Status berubah menjadi *Approved*.
4. **Finalisasi (Tahap 4 - Penandatanganan):** Dosen Tujuan menerima notifikasi (terisolasi hanya melihat dokumen yang ditujukan kepadanya). Dosen mengunggah dokumen yang telah ditandatangani. Sistem akan melakukan *generate Hash Verifikasi (32-character string)* yang unik. Status berubah menjadi *Signed*.
5. **Verifikasi Publik:** Dokumen akhir dapat diverifikasi keasliannya oleh pihak luar menggunakan link publik `/verify/{hash}` tanpa memerlukan autentikasi login.

---

## 🧩 Komponen Utama
*   **Modul Autentikasi & RBAC (Role-Based Access Control):** Mengatur 5 level otorisasi pengguna secara aman untuk memastikan data terisolasi dengan benar (misal: dosen hanya melihat dokumennya sendiri).
*   **Manajemen Dosen:** Modul CRUD khusus untuk mengelola profil dosen, meliputi atribut spesifik seperti NIDN/NIP, Jabatan Struktural (Dosen Biasa, Kaprodi, Sekprodi, Dekan), dan email institusi.
*   **Document Engine:** Mesin utama yang menangani unggah (*upload*), penyimpanan lokal (*secure private storage*), dan pengunduhan (*download*) berbagai versi file (Asli, Ber-stempel, dan Ber-tanda tangan).
*   **Activity Logger:** Sistem pencatatan riwayat (Audit Trail) yang merekam setiap aksi secara kronologis (dari terbaru ke terlama), mencatat siapa, kapan, dan tindakan apa yang dilakukan pada dokumen.
*   **Dashboard & Analytics:** Memberikan visualisasi cepat terkait jumlah dokumen yang diajukan, diproses, selesai, serta fitur peringatan otomatis (*Overdue Indicator*) untuk dokumen yang belum diproses lebih dari 2 hari.
*   **Bulk Actions:** Fitur produktivitas untuk Super Admin dan Admin guna mengelola dan menghapus banyak dokumen tertolak secara bersamaan.

---

## 🧪 Quality Testing Results
Pengujian fungsional dan keamanan sistem telah dilakukan dengan hasil sebagai berikut:

*   **Role Isolation Test:** **PASS (100%)**
    *   Mahasiswa tidak dapat mengakses ID dokumen mahasiswa lain.
    *   Dosen hanya dapat melihat dan memanipulasi dokumen dengan `target_lecturer_id` yang cocok dengan ID mereka sendiri. Uji coba akses melalui URL langsung mengembalikan status `403 Forbidden`.
*   **File Upload Validation:** **PASS (100%)**
    *   Sistem berhasil menolak file selain `pdf, jpg, jpeg, png` dan memblokir unggahan file di atas 4MB.
    *   Penyimpanan file terproteksi di disk *local* private; akses ke file hanya dapat dilakukan melalui rute terkontrol (Controller) untuk mencegah *direct download*.
*   **Workflow Integrity:** **PASS (100%)**
    *   Proses *Revert* status berfungsi dengan benar tanpa menghapus riwayat dokumen.
    *   Sistem pembubuhan stempel dan tanda tangan berhasil menimpa (*override*) prioritas tampilan pratinjau (Preview) ke versi dokumen paling final (*Signed* > *Stamped* > *Original*).
*   **Overdue Calculation Logic:** **PASS (100%)**
    *   Sistem berhasil mendeteksi dan memberi label *Overdue* pada dokumen yang stagnan (tidak ada log aktivitas baru) lebih dari 48 jam (2 hari), kecuali untuk dokumen yang sudah mencapai status *Signed* atau *Rejected*.
