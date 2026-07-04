# Plan Memperkaya Dashboard

## Tujuan

Membuat halaman `dashboard` tidak terlalu kosong dengan menambahkan konten ringkasan yang relevan untuk aplikasi Undangan Digital & RSVP, tanpa mengubah alur utama CRUD event atau RSVP.

## Kondisi Saat Ini

- `resources/views/dashboard.blade.php` hanya berisi satu kartu sambutan statis.
- Route `/dashboard` di `routes/web.php` masih berupa closure:
  - `return view('dashboard');`
- Data yang bisa dipakai sudah tersedia lewat model:
  - `Event` memiliki relasi `rsvps()`.
  - `Rsvp` menyimpan `status_hadir`, `jumlah_orang`, dan `ucapan`.
- Event dimiliki user melalui kolom `user_id`.

## Keputusan Desain

- Dashboard akan menjadi halaman ringkasan SaaS sederhana, bukan hanya greeting.
- Konten yang ditambahkan:
  1. Hero/welcome card yang lebih informatif.
  2. Kartu statistik ringkas.
  3. Aksi cepat untuk membuat undangan dan melihat daftar undangan.
  4. Daftar undangan terbaru.
  5. Empty state yang bagus jika user belum punya undangan.
- Tetap memakai visual token yang sudah dibuat sebelumnya: `paper`, `ink`, `evergreen`, `brass`, `mist`, `font-display`.

## Perubahan Yang Direncanakan

### 1. Update Route Dashboard

File: `routes/web.php`

- Tambahkan import model jika belum ada:
  - `use App\Models\Event;`
- Ubah closure dashboard agar mengambil data milik user login:
  - `$events = Event::withCount('rsvps')->where('user_id', auth()->id())->latest()->take(5)->get();`
  - `$totalEvents = Event::where('user_id', auth()->id())->count();`
  - `$totalResponses = ...` memakai relasi `rsvps` dari event milik user.
  - `$totalGuests = ...` sum `jumlah_orang` untuk RSVP `hadir` dari event milik user.
- Kirim data ke view:
  - `events`
  - `totalEvents`
  - `totalResponses`
  - `totalGuests`

Catatan implementasi:
- Pakai query yang aman terbatas pada `user_id = auth()->id()`.
- Hindari menampilkan RSVP dari event milik user lain.
- Tidak perlu membuat controller baru kecuali implementer ingin merapikan struktur. Perubahan minimal cukup di closure route.

### 2. Update Tampilan Dashboard

File: `resources/views/dashboard.blade.php`

Ganti isi dashboard menjadi layout berikut:

1. Header tetap:
   - `Dashboard`
   - class `font-display text-2xl text-ink` tetap dipertahankan.

2. Hero card:
   - Card putih border `mist`, rounded `2xl`, shadow custom.
   - Judul seperti `Selamat datang, {{ Auth::user()->name }}`.
   - Deskripsi singkat tentang mengelola undangan dan memantau RSVP.
   - Tombol utama `Buat Undangan` menuju `route('events.create')`.
   - Tombol sekunder `Lihat Undangan` menuju `route('events.index')`.

3. Statistik 3 kartu:
   - `Total Undangan` dari `$totalEvents`.
   - `Total RSVP` dari `$totalResponses`.
   - `Tamu Akan Hadir` dari `$totalGuests`.
   - Gunakan variasi warna:
     - evergreen untuk undangan/kehadiran.
     - brass untuk RSVP.
     - mist untuk kartu netral.

4. Daftar undangan terbaru:
   - Jika `$events->isNotEmpty()`:
     - Tampilkan maksimal 5 event.
     - Tampilkan nama acara, tanggal, lokasi, jumlah RSVP (`rsvps_count`), dan link `Detail`.
     - Tambahkan link publik undangan dalam `font-mono text-evergreen` jika ruang cukup.
   - Jika kosong:
     - Tampilkan empty state dengan copy ramah seperti `Belum ada undangan aktif`.
     - Tombol `Buat Undangan Pertama`.

5. Panel tips kecil opsional:
   - Contoh isi: `Bagikan link undangan setelah acara dibuat`, `Pantau RSVP dari halaman detail undangan`, `Edit data acara kapan saja`.
   - Ini membuat dashboard terasa penuh tanpa menambah data baru.

## Batasan

- Tidak mengubah migration, model, controller event, controller RSVP, atau form RSVP.
- Tidak mengubah struktur database.
- Tidak mengubah route resource events.
- Tidak menambah JavaScript.
- Tidak menambah library baru.
- Tidak memakai warna default `blue/indigo/gray` untuk elemen utama.

## Risiko Dan Mitigasi

- Risiko query RSVP salah menghitung data user lain.
  - Mitigasi: semua query RSVP harus dibatasi melalui event milik `auth()->id()`.
- Risiko dashboard error jika user belum punya event.
  - Mitigasi: gunakan collection kosong dan empty state.
- Risiko terlalu banyak query.
  - Mitigasi: gunakan `withCount('rsvps')` untuk daftar event terbaru dan query agregat sederhana untuk statistik.

## Validasi

1. Jalankan `npm run build` untuk memastikan Tailwind/Vite compile.
2. Login sebagai user yang belum punya event:
   - Dashboard menampilkan statistik 0 dan empty state.
3. Login sebagai user yang punya event:
   - Statistik terisi.
   - Undangan terbaru tampil maksimal 5.
   - Tombol `Buat Undangan`, `Lihat Undangan`, dan `Detail` mengarah ke route yang benar.
4. Pastikan tidak ada data event/RSVP user lain yang muncul.
5. Pastikan tampilan tetap responsif di mobile.

## File Yang Akan Diubah

- `routes/web.php`
- `resources/views/dashboard.blade.php`
