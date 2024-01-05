# Sistem Informasi Manajemen Pengawasan

Sistem Manajemen Pengawasan adalah aplikasi berbasis web yang dibangun untuk membantu pengawasan dan manajemen kinerja pegawai. Aplikasi ini terdiri dari beberapa modul yang dirancang untuk berbagai aspek manajemen, termasuk:

1. **Modul Perencanaan dan Realisasi Kinerja Pegawai**

   - [Deskripsi singkat tentang modul ini]

2. **Modul Pengelolaan Dokumen**

   - [Deskripsi singkat tentang modul ini]

3. **Modul Pegawai**

   - [Deskripsi singkat tentang modul ini]

4. **Modul Unit Kerja**

   - [Deskripsi singkat tentang modul ini]

## Teknologi Stack

Aplikasi ini dibangun menggunakan teknologi berikut:

- Laravel
- MariaDB/MySQL
- Bootstrap

## Getting Started

Berikut adalah langkah-langkah untuk memulai development aplikasi:

### Option 1 

1. Clone repositori ini ke komputer lokal Anda.

   ```bash
   git clone [url]
   cd [folder]
   ```

2. Copy file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database dan Google Client ID.

   ```bash
   cp .env.example .env
   ```

3. Jalankan script `setup.sh` untuk menginstall dependensi dan mengkonfigurasi aplikasi.

    ```bash
    ./setup.sh
    ```

### Option 2 - Docker
1. Clone repositori ini ke komputer lokal Anda.

   ```bash
   git clone [url]
   cd [folder]
   ```

2. Copy file `.env.example` menjadi `.env` dan sesuaikan konfigurasi database dan Google Client ID.

   ```bash
    cp .env.example .env
    ```

3. Jalankan docker-compose untuk membangun dan menjalankan aplikasi.

    ```bash
    docker-compose up -d
    ```

4. Jalankan script `setup.sh` untuk menginstall dependensi dan mengkonfigurasi aplikasi.

    ```bash
    ./setup.sh
    ```

## Kontak

Untuk pertanyaan atau bantuan, silakan hubungi kami melalui [email](#)

## Coding Convention
1. Git-Flow Workflow (https://danielkummer.github.io/git-flow-cheatsheet/)
2. Conventional Commits (https://www.conventionalcommits.org/en/v1.0.0/)



## Roadmap

Berikut adalah beberapa fitur yang akan dikembangkan untuk aplikasi ini :

- [ ] Modul Unit Kinerja
- [ ] Modul Pegawai
- [ ] Dokumentasi
- [ ] Testing

## Lisensi

Aplikasi ini menggunakan lisensi [MIT](/LICENSE).
