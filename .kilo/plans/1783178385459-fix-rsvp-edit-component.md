# Plan: Fix rsvp/edit.blade.php - Use invitation-card Component

## Status

File `resources/views/rsvp/edit.blade.php` tidak konsisten dengan spesifikasi Langkah 8 dari implementasi fitur Canva-style.

## Problem

**File yang sudah sesuai:**
- ✅ `resources/views/rsvp/show.blade.php` - sudah menggunakan `<x-invitation-card>` component (line 30-42)
- ✅ `resources/views/events/edit.blade.php` - sudah menggunakan `<x-invitation-card>` untuk live preview (line 117-129)

**File yang belum sesuai:**
- ❌ `resources/views/rsvp/edit.blade.php` - masih menggunakan card manual sederhana (line 29-36)

### Dampak Inkonsistensi

File `rsvp/edit.blade.php` saat ini:
- Tidak menampilkan foto undangan
- Tidak mendukung layout variants (foto_atas, foto_samping, tanpa_foto)
- Tidak menampilkan detail lengkap (nama mempelai, orang tua untuk pernikahan)
- Tidak konsisten dengan tampilan `rsvp/show.blade.php`
- User yang membuka link edit RSVP tidak melihat kartu undangan lengkap seperti saat mereka pertama kali mengisi RSVP

## Goal

Ganti card manual di `resources/views/rsvp/edit.blade.php` dengan komponen `<x-invitation-card>` agar:
1. Konsisten dengan `rsvp/show.blade.php`
2. Menampilkan kartu undangan lengkap dengan foto, layout, dan semua detail
3. Memberikan konteks visual yang sama seperti saat pertama kali user mengisi RSVP

## Scope

### In Scope
- Update `resources/views/rsvp/edit.blade.php` untuk menggunakan `<x-invitation-card>` component
- Pertahankan form edit RSVP yang sudah ada (line 38-87)
- Pertahankan struktur HTML, fonts import, dan styling yang sudah ada

### Out of Scope
- Tidak mengubah `resources/views/rsvp/show.blade.php` (sudah benar)
- Tidak mengubah `resources/views/events/edit.blade.php` (sudah benar)
- Tidak mengubah component `invitation-card.blade.php`
- Tidak mengubah controller, route, atau business logic
- Tidak mengubah UI design system (tetap menggunakan token warna yang ada)

## Changes Required

### File: `resources/views/rsvp/edit.blade.php`

**Sebelum (line 29-36):**
```blade
<div class="{{ $cardClass }} p-10 md:p-12 mb-12 text-center">
    <p class="text-xs uppercase tracking-wider text-ink/50">Undangan</p>
    <h1 class="mt-3 font-display text-4xl font-semibold {{ $titleClass }}">{{ $rsvp->event->nama_acara }}</h1>
    <p class="mt-4 text-sm text-ink/50">
        {{ \Carbon\Carbon::parse($rsvp->event->tanggal_utama)->translatedFormat('d F Y') }}
        • {{ $rsvp->event->lokasi_utama }}
    </p>
</div>
```

**Sesudah (replace line 29-36):**
```blade
{{-- Kartu Undangan --}}
<x-invitation-card
    :eventType="$rsvp->event->template->event_type"
    :layoutType="$rsvp->event->layout_type"
    :namaAcara="$rsvp->event->nama_acara"
    :tanggalUtama="\Carbon\Carbon::parse($rsvp->event->tanggal_utama)->translatedFormat('d F Y')"
    :jamUtama="\Carbon\Carbon::parse($rsvp->event->jam_utama)->format('H:i')"
    :lokasiUtama="$rsvp->event->lokasi_utama"
    :namaMempelaiPria="$rsvp->event->nama_mempelai_pria"
    :namaMempelaiWanita="$rsvp->event->nama_mempelai_wanita"
    :namaOrtuPria="$rsvp->event->nama_ortu_pria"
    :namaOrtuWanita="$rsvp->event->nama_ortu_wanita"
    :fotoUrl="$rsvp->event->foto_utama_url"
/>
```

**Section berikutnya tetap dipertahankan:**
- Form edit RSVP (line 38-87) tidak diubah
- Semua atribut form, `@csrf`, `@method('PUT')`, field names, dan button tetap sama

## Data Flow

1. User membuka link edit RSVP via token (`/rsvp/edit/{token}`)
2. `RsvpController@edit` load data `$rsvp` dengan relasi `$rsvp->event->template`
3. Blade file render `<x-invitation-card>` dengan props dari `$rsvp->event`
4. Component `invitation-card.blade.php` render layout sesuai `$rsvp->event->layout_type`:
   - `foto_atas`: foto full width di atas, konten di bawah
   - `foto_samping`: foto di kiri, konten di kanan
   - `tanpa_foto`: fokus pada teks dengan ornamen SVG
5. Component render theme sesuai `$rsvp->event->template->event_type`:
   - `pernikahan`: evergreen/brass colors
   - `ulang_tahun`: blush colors
6. Form edit RSVP tetap muncul di bawah kartu undangan

## Edge Cases & Validation

### Edge Cases
1. **Event tanpa foto**: Component sudah handle dengan placeholder "Foto belum diupload"
2. **Event ulang tahun**: Tidak perlu nama mempelai/ortu, component sudah handle conditional rendering
3. **Event pernikahan tanpa data orang tua**: Component tidak render section orang tua jika kosong
4. **Layout `tanpa_foto`**: Component render dengan ornamen SVG decorative

### Validation Steps
1. Buka link edit RSVP untuk event pernikahan dengan layout `foto_atas` dan foto → kartu undangan lengkap dengan foto muncul
2. Buka link edit RSVP untuk event ulang tahun dengan layout `foto_samping` → kartu undangan dengan foto samping muncul
3. Buka link edit RSVP untuk event dengan layout `tanpa_foto` → kartu undangan fokus teks dengan ornamen muncul
4. Buka link edit RSVP untuk event tanpa foto → placeholder "Foto belum diupload" muncul
5. Submit form edit RSVP → data berhasil diupdate (logic tidak berubah)
6. Cek konsistensi visual antara `rsvp/show.blade.php` dan `rsvp/edit.blade.php` → kartu undangan terlihat identik

## Risks & Mitigations

### Risk 1: Relasi `$rsvp->event->template` tidak eager loaded
**Likelihood:** Low  
**Impact:** Medium (N+1 query atau error jika relasi null)  
**Mitigation:** Verifikasi `RsvpController@edit` sudah load relasi `->with('event.template')`. Jika belum, tambahkan eager loading.

### Risk 2: User bingung melihat kartu besar di halaman edit
**Likelihood:** Low  
**Impact:** Low  
**Mitigation:** Ini sebenarnya improvement - user mendapat konteks visual lengkap saat mengedit RSVP mereka. Konsisten dengan flow di `rsvp/show.blade.php`.

### Risk 3: Mobile viewport terlalu panjang
**Likelihood:** Low  
**Impact:** Low  
**Mitigation:** Component `invitation-card` sudah responsive dengan Tailwind classes. Layout `foto_samping` menggunakan `flex-col md:flex-row`.

## Implementation Steps

1. Backup file `resources/views/rsvp/edit.blade.php` (git sudah track, safe untuk revert)
2. Verifikasi `RsvpController@edit` eager load relasi `event.template`:
   ```php
   $rsvp = Rsvp::with('event.template')->where('edit_token', $token)->firstOrFail();
   ```
3. Edit `resources/views/rsvp/edit.blade.php`:
   - Replace line 29-36 dengan pemanggilan `<x-invitation-card>`
   - Gunakan exact props seperti di `rsvp/show.blade.php`
4. Test di browser:
   - Event pernikahan dengan foto_atas
   - Event ulang tahun dengan foto_samping
   - Event dengan tanpa_foto
   - Submit form edit untuk memastikan logic tidak broken
5. Compare visual `rsvp/show` vs `rsvp/edit` → harus identik untuk bagian kartu undangan

## Dependencies

- Component `resources/views/components/invitation-card.blade.php` (sudah ada ✅)
- Model relasi `Rsvp->event->template` (sudah ada ✅)
- Accessor `Event->foto_utama_url` (sudah ada ✅)
- Tailwind tokens (sudah ada ✅)
- Carbon untuk format tanggal (sudah dipakai ✅)

## Rollback Plan

Jika terjadi masalah:
1. `git checkout resources/views/rsvp/edit.blade.php` untuk revert ke versi sebelumnya
2. Atau manual restore line 29-36 dengan card sederhana original

## Post-Implementation

Setelah implementasi:
1. Update dokumentasi plan `1783170114390-dashboard-content-plan.md` status dari "Langkah 8: Selesai ✅" dengan catatan "rsvp/edit juga sudah diupdate"
2. Commit dengan message: `Fix rsvp/edit.blade.php to use invitation-card component`
3. User dapat melanjutkan ke implementasi UI design plan (plan 1783169713632) jika diinginkan

## Open Questions

None. Plan sudah jelas dan tidak ada ambiguitas.
