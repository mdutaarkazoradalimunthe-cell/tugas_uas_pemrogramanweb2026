# Plan UI Undangan Digital & RSVP

## Status

Source code belum diubah. Plan ini dibuat setelah membaca file Blade, Tailwind config, dan CSS yang relevan.

## Tujuan

Mengubah tampilan Laravel Blade + Tailwind untuk aplikasi SaaS "Undangan Digital & RSVP" sesuai prompt desain, tanpa mengubah logic PHP/controller, route, nama field form, method form, `@csrf`, `@method`, `old(...)`, atau binding variable Blade.

## File Yang Perlu Diubah

1. `tailwind.config.js`
2. `resources/css/app.css`
3. `resources/views/layouts/app.blade.php`
4. `resources/views/layouts/guest.blade.php`
5. `resources/views/layouts/navigation.blade.php`
6. `resources/views/components/primary-button.blade.php`
7. `resources/views/components/secondary-button.blade.php`
8. `resources/views/components/danger-button.blade.php`
9. `resources/views/components/text-input.blade.php`
10. `resources/views/components/input-label.blade.php`
11. `resources/views/components/nav-link.blade.php`
12. `resources/views/components/responsive-nav-link.blade.php`
13. `resources/views/auth/login.blade.php`
14. `resources/views/auth/register.blade.php`
15. `resources/views/dashboard.blade.php`
16. `resources/views/events/index.blade.php`
17. `resources/views/events/create.blade.php`
18. `resources/views/events/edit.blade.php`
19. `resources/views/events/show.blade.php`
20. `resources/views/rsvp/show.blade.php`
21. `resources/views/rsvp/edit.blade.php`

## Temuan Dari Pembacaan File

- `tailwind.config.js` masih memakai font default Breeze `Figtree`; token warna/font dari prompt belum ada.
- `resources/css/app.css` hanya berisi direktif Tailwind, belum ada base styling tambahan.
- Layout dashboard masih memakai `bg-gray-100`, `text-gray-*`, dan header `shadow` default.
- Layout guest masih memakai font Bunny/Figtree, background gray, card `shadow-md`, dan logo default Breeze.
- Navigation dan komponen nav masih memakai `indigo`/`gray` default Breeze.
- Komponen form Breeze (`primary-button`, `text-input`, `input-label`, dll.) masih memakai token default sehingga auth/profil akan tetap terlihat default jika komponen tidak ikut disesuaikan.
- `events/create.blade.php` dan `events/edit.blade.php` memiliki script `toggleFields()` yang harus dipertahankan. Hanya class/markup visual boleh diubah.
- `rsvp/show.blade.php` dan `rsvp/edit.blade.php` adalah full HTML documents, bukan memakai layout app/guest, sehingga import Google Fonts perlu ditambahkan langsung di masing-masing `<head>` sebelum `@vite`.
- Prompt menyebut auth dan dashboard/events, tetapi profile partials juga memakai komponen Breeze. Dengan mengubah komponen dasar, halaman profile akan ikut mengikuti token tanpa perlu mengedit logic profile.

## Keputusan Implementasi

- Dashboard/auth memakai visual SaaS profesional: `bg-paper`, `text-ink`, card putih `rounded-2xl`, `border border-mist`, shadow custom `shadow-[0_4px_24px_-4px_rgba(33,38,31,0.08)]`.
- Halaman RSVP publik memakai visual undangan: background paper/mist, border brass, `font-display`, ornament SVG hanya di `rsvp/show.blade.php` dan `rsvp/edit.blade.php`.
- Tema RSVP ditentukan langsung dari existing expression:
  - `pernikahan`: `$event->template->event_type === 'pernikahan'` atau `$rsvp->event->template->event_type === 'pernikahan'`.
  - selain itu dianggap `ulang_tahun` dan memakai blush.
- Tidak menambah animasi kompleks; hanya `transition-colors duration-150` untuk hover/focus.
- Tetap boleh memakai warna status merah muted untuk error/delete sesuai prompt. Hindari `blue-600`, `indigo-600`, dan palet default yang tidak diperlukan.

## Rencana Perubahan Detail

### 1. Tailwind Tokens

Update `tailwind.config.js` di `theme.extend`:

- Tambahkan `colors.paper`, `colors.ink`, `colors.evergreen`, `colors.brass`, `colors.blush`, `colors.mist` sesuai prompt.
- Ganti font family menjadi:
  - `display: ['Fraunces', 'serif']`
  - `sans: ['Inter', 'sans-serif']`
  - `mono: ['"IBM Plex Mono"', 'monospace']`
- Hapus ketergantungan visual pada Figtree. Import `defaultTheme` bisa tetap ada jika masih diperlukan, tetapi plan minimalnya dapat menghapus pemakaian Figtree dari extend.

### 2. CSS Base

Update `resources/css/app.css` secara minimal:

- Tambahkan `@layer base` untuk `body` dengan `bg-paper text-ink font-sans`.
- Opsional tambahkan selection color halus memakai `bg-brass-light text-ink`.
- Jangan menambahkan utility kompleks jika bisa dilakukan via class Blade.

### 3. Font Import

Tambahkan Google Fonts sebelum `@vite` di:

- `resources/views/layouts/app.blade.php`
- `resources/views/layouts/guest.blade.php`
- `resources/views/rsvp/show.blade.php`
- `resources/views/rsvp/edit.blade.php`

Ganti font Bunny/Figtree di layout app/guest dengan link Google Fonts dari prompt.

### 4. Layout Dashboard

Update `resources/views/layouts/app.blade.php`:

- `body`: `font-sans text-ink antialiased`.
- Root wrapper: `min-h-screen bg-paper`.
- Header: ganti `bg-white shadow` menjadi `bg-paper border-b border-mist`.
- Header inner tetap mempertahankan slot `{{ $header }}`.

Update `resources/views/layouts/navigation.blade.php`:

- Nav: `bg-paper border-b border-mist`.
- Logo link dapat diberi teks brand memakai `font-display text-xl text-evergreen` atau tetap memakai `x-application-logo` dengan class evergreen. Pilih minimal: tambahkan teks app name di samping logo agar terasa brand.
- Dropdown trigger: ganti gray classes ke `text-ink/70 hover:text-ink bg-paper`.
- Mobile hamburger: ganti gray hover/focus ke mist/evergreen.
- Responsive top border: `border-mist`.

Update components nav:

- `nav-link.blade.php`: active `border-evergreen text-evergreen`; inactive `text-ink/60 hover:text-ink hover:border-brass-light`.
- `responsive-nav-link.blade.php`: active `border-evergreen text-evergreen bg-evergreen/5`; inactive `text-ink/70 hover:text-ink hover:bg-mist/40 hover:border-brass-light`.

### 5. Guest/Auth Foundation

Update `resources/views/layouts/guest.blade.php`:

- Body: `font-sans text-ink antialiased`.
- Wrapper: `min-h-screen flex ... bg-paper px-4`.
- Card: `bg-white border border-mist shadow-[...] rounded-2xl`.
- Logo: use evergreen/ink instead of gray.

Update component form defaults:

- `primary-button.blade.php`: `bg-evergreen text-paper hover:bg-evergreen-dark rounded-lg focus:ring-evergreen`.
- `secondary-button.blade.php`: `bg-transparent border-mist text-ink hover:bg-mist/40 rounded-lg focus:ring-evergreen`.
- `danger-button.blade.php`: `bg-red-50 text-red-700 hover:bg-red-100 rounded-lg`, muted delete style.
- `text-input.blade.php`: `border-mist focus:border-evergreen focus:ring-evergreen rounded-lg shadow-none`.
- `input-label.blade.php`: `text-ink/70 font-medium`.

Update `auth/login.blade.php` and `auth/register.blade.php`:

- Add page title above form with `font-display text-3xl text-ink`.
- Labels/inputs inherit component styling.
- Checkbox in login: replace `border-gray-300 text-indigo-600 focus:ring-indigo-500` with `border-mist text-evergreen focus:ring-evergreen`.
- Links: replace gray/indigo focus with `text-ink/60 hover:text-evergreen focus:ring-evergreen`.
- Keep all form actions, `@csrf`, input names, `old(...)`, required/autocomplete attributes unchanged.

### 6. Dashboard

Update `resources/views/dashboard.blade.php`:

- Header title `font-display text-2xl text-ink`.
- Content card `bg-white border border-mist rounded-2xl shadow-[...]`.
- Body text `text-ink/80`.
- Optional add short SaaS welcome copy without changing logic.

### 7. Events Index

Update `resources/views/events/index.blade.php`:

- Header title `font-display text-2xl text-ink`.
- Success alert use `bg-evergreen/10 text-evergreen-dark border border-evergreen/20`.
- Main card `bg-white border border-mist rounded-2xl shadow-[...]`.
- Create button `bg-evergreen text-paper hover:bg-evergreen-dark rounded-lg`.
- Event rows `border border-mist rounded-2xl`.
- Link URL text use `font-mono text-evergreen` instead of blue.
- Detail/Edit secondary buttons use transparent/mist/brass styles.
- Delete button muted red `bg-red-50 text-red-700 hover:bg-red-100`.

### 8. Events Create/Edit

Update `resources/views/events/create.blade.php` and `resources/views/events/edit.blade.php`:

- Header titles `font-display text-2xl text-ink`.
- Form card `bg-white border border-mist rounded-2xl shadow-[...] p-6`.
- Error alert muted red with border.
- Labels `text-sm font-medium text-ink/70`.
- Inputs/selects `border-mist rounded-lg focus:border-evergreen focus:ring-evergreen`.
- Replace `<hr class="my-6">` with dashboard-safe divider `border-t border-mist my-6`, not signature ornament.
- Primary submit button evergreen.
- Cancel button transparent border `border-mist text-ink hover:bg-mist/40`.
- Preserve `toggleFields()` function and `onchange="toggleFields()"` exactly enough to keep behavior.

### 9. Events Show

Update `resources/views/events/show.blade.php`:

- Header title `font-display text-2xl text-ink`.
- All cards `bg-white border border-mist rounded-2xl shadow-[...] p-6`.
- Detail labels `text-ink/50`, values `text-ink`.
- Shared invitation link box `bg-paper border border-mist`; URL `font-mono text-evergreen`.
- RSVP summary cards:
  - Hadir: `bg-evergreen/10 text-evergreen-dark border-evergreen/20`.
  - Tidak hadir: use `bg-brass/10 text-brass border-brass/20` or muted red only if clarity is preferred. Prompt asks palette accents, so use brass.
  - Total: `bg-mist/40 text-ink border-mist`.
- Table headers use `border-mist text-ink/50`.
- Row status: hadir `text-evergreen`, tidak hadir `text-brass` to avoid default red dominance.

### 10. RSVP Show

Update `resources/views/rsvp/show.blade.php` heavily but only in markup/classes:

- Add Google Fonts before `@vite`.
- Add Blade `@php` theme variables near body start, for example:
  - `$isWedding = $event->template->event_type === 'pernikahan';`
  - `$accentClass = $isWedding ? 'evergreen' : 'blush';`
  Keep this presentational only.
- Body background:
  - Wedding: `bg-gradient-to-b from-paper to-mist`.
  - Birthday: `bg-paper` with subtle blush-tinted decorative background using absolutely positioned divs if desired.
- Main structure order must be: info acara, signature divider, form RSVP, signature divider, daftar ucapan.
- Card invitation:
  - Wedding: `bg-paper/90 border border-brass/60 rounded-2xl` and minimal shadow or no heavy shadow.
  - Birthday: `bg-white border border-blush/30 rounded-[2rem]` with elegant playful shape.
- Wedding title: `font-display text-4xl md:text-5xl text-evergreen tracking-wide`.
- Birthday title: `font-display text-4xl md:text-5xl text-blush tracking-wide`.
- Info labels: uppercase small label `font-sans uppercase tracking-wide text-xs text-ink/60`.
- Replace RSVP button blue with conditional evergreen/blush classes.
- RSVP form labels use prompt style.
- Inputs/select/textarea `border-mist rounded-lg focus:ring-evergreen/focus:ring-blush` according to theme. Since dynamic class names may not be detected by Tailwind, use explicit Blade branches or safelist-free static class strings.
- Add signature divider SVG between info and form, and between form and ucapan. Use exact SVG from prompt.
- Daftar ucapan cards: small cards with quote mark decorative `&ldquo;` or positioned `span`, not bullet-style border-b list.
- Keep `route('rsvp.store', $event->unique_slug)`, `@csrf`, field names, `old(...)`, required/min/rows unchanged.

### 11. RSVP Edit

Update `resources/views/rsvp/edit.blade.php`:

- Add Google Fonts before `@vite`.
- Add presentational theme variables using `$rsvp->event->template->event_type`.
- Use same invitation theme system as RSVP show.
- One card form plus top invitation summary.
- Add signature divider above form title as requested.
- Button uses conditional evergreen/blush.
- Inputs/select/textarea use mist border and theme focus.
- Keep `route('rsvp.update', $rsvp->edit_token)`, `@csrf`, `@method('PUT')`, names, values, and status option logic unchanged.

## Hal Yang Tidak Diubah

- Tidak mengubah controller, model, migration, route, request validation, database, atau logic PHP bisnis.
- Tidak mengubah nama input seperti `template_id`, `nama_acara`, `status_hadir`, `jumlah_orang`, dan lainnya.
- Tidak menghapus `@csrf`, `@method('PUT')`, `@method('DELETE')`, `old(...)`, `@if`, atau `@foreach` yang diperlukan.
- Tidak menambahkan React/Vue.
- Tidak memakai signature ornament di dashboard/events/auth.

## Risiko Dan Mitigasi

- Tailwind JIT mungkin tidak menangkap class yang dibentuk dinamis. Mitigasi: gunakan class lengkap secara eksplisit dalam cabang Blade, bukan string seperti `text-{{ $accent }}`.
- Komponen Breeze dipakai juga oleh halaman profile/forgot/reset. Mengubah komponen akan memperbaiki konsistensi, tetapi perlu cek tampilan auth/profile setelah implementasi.
- Prompt meminta menjalankan `npm run dev` setelah tiap halaman, tetapi dalam implementasi praktis cukup jalankan build/dev verification setelah batch perubahan. Jika mengikuti prompt ketat, implementer dapat menjalankan `npm run dev` sekali dan biarkan aktif saat cek manual.

## Validasi Setelah Implementasi

1. Jalankan `npm run build` untuk memastikan Tailwind/Vite compile tanpa error.
2. Jika ingin cek browser interaktif, jalankan `npm run dev`.
3. Buka halaman login dan register, pastikan tidak ada visual indigo/blue default.
4. Buka dashboard dan semua halaman events, pastikan card, tombol, dan tabel memakai token baru.
5. Buka undangan publik untuk template `pernikahan`, pastikan evergreen/brass, font display, dan signature divider muncul.
6. Buka undangan publik untuk template `ulang_tahun`, pastikan blush menjadi aksen utama.
7. Submit form RSVP test, pastikan field/action/method tetap berfungsi.
8. Buka edit RSVP via token, pastikan `@method('PUT')` dan value lama tetap muncul.

## Laporan Untuk User

Belum ada file project yang diubah pada sesi ini. Yang sudah dilakukan adalah membaca file relevan dan menyiapkan rencana perubahan UI. Jika nanti plan ini diimplementasikan, perubahan akan terbatas pada styling Tailwind, markup visual Blade, import font, dan token Tailwind seperti daftar di atas.
