# Plan: Category-Specific Forms & Template Preview

## User Request Summary

1. Tab "Acara Lainnya" tidak menampilkan templates (kemungkinan data duplicate di DB)
2. Form fields tidak spesifik per kategori - semua kategori menggunakan form yang sama
3. Tidak ada preview template - user tidak bisa melihat gambaran template sebelum memilih
4. Perlu tambahkan form fields spesifik untuk:
   - Pernikahan: sudah ada (nama mempelai, orang tua, resepsi) ✓
   - Ulang Tahun: perlu tambahan (usia, tema pesta, dll)
   - Acara Lainnya: perlu tambahan (jumlah peserta, speaker, dll)

## Current State Investigation Needed

**Before planning, I need to understand:**

### Q1: Template Database Status

Seeder kemungkinan dijalankan multiple times causing duplicates (total 22 templates instead of expected 10).

**Options:**
A. Truncate templates table dan re-seed clean data (Recommended - fresh start)
B. Manual delete duplicates via SQL
C. Create migration to remove duplicates

**My recommendation:** Option A - truncate and reseed

**Question for you:** Apakah ada data templates yang sudah digunakan oleh events? Atau masih development/testing saja? Jika sudah ada events menggunakan templates, kita perlu Option B/C yang lebih careful.

### Q2: Category-Specific Fields Requirements

**For Ulang Tahun (Birthday), which additional fields do you want?**

Possible fields:
- Usia/umur yang ke berapa (required?)
- Nama yang berulang tahun (already covered by nama_acara)
- Tema pesta (dropdown: Kids Party, Sweet Seventeen, Adult Birthday, etc)
- Dress code (optional text)
- Gift registry info (optional text)
- RSVP deadline date (optional)

**For Acara Lainnya (Other Events), which additional fields do you want?**

Possible fields for Seminar/Workshop:
- Jumlah kursi/kapasitas peserta (number)
- Nama pembicara/speaker (text, optional multiple?)
- Topik/agenda (textarea)
- Biaya tiket (number, optional)
- Link pendaftaran external (url, optional)
- Dresscode (Formal/Casual/Business Casual dropdown)

Possible fields for Gathering/Makrab:
- Tema gathering (text)
- Dresscode (Casual/Themed/etc)
- Catatan khusus (textarea)
- Iuran/kontribusi (number, optional)

**Question for you:** 
- Apakah Acara Lainnya perlu dibedakan antara "Seminar" dan "Gathering"? Atau satu form yang flexible untuk keduanya?
- Field mana saja yang wajib diisi vs optional?

### Q3: Template Preview Design

**How should the preview modal work?**

**Option A: Image-based preview** (Recommended)
- Template cards show actual screenshot/mockup image
- Click template → opens larger modal with full preview image
- Pros: Visual, easy to understand
- Cons: Need to create/upload preview images for each template

**Option B: Live component preview**
- Template cards show miniature of actual `<x-invitation-card>` component
- Click template → opens modal with full-size live preview
- Pros: Always accurate, no need for separate images
- Cons: More complex, requires dummy data

**Option C: Hybrid**
- Template cards show gradient thumbnail (current)
- Click "Preview" button → opens modal with live component preview using dummy data
- Balance between simplicity and functionality

**My recommendation:** Option C for MVP

**Question for you:** Which preview approach do you prefer? Option A requires creating preview images, Option B/C uses code-based preview.

### Q4: Database Schema Changes

New fields will need:
- Migration to add columns to `events` table
- Update `Event` model `$fillable`
- Update validation rules in `EventController`

**Proposed new columns:**

```sql
-- For ulang_tahun
usia_tahun INT NULL
tema_pesta VARCHAR(255) NULL
dress_code VARCHAR(255) NULL

-- For acara_lainnya
kapasitas_peserta INT NULL
nama_pembicara TEXT NULL
topik_agenda TEXT NULL
biaya_tiket DECIMAL(10,2) NULL
link_pendaftaran VARCHAR(255) NULL
```

**Question for you:** Are these field names acceptable? Any other fields you want to add?

### Q5: Form Visibility Logic

Currently only `pernikahan-fields` div exists and toggles based on event type.

**Proposed structure:**
```blade
<div id="pernikahan-fields" class="hidden">...</div>
<div id="ulang_tahun-fields" class="hidden">...</div>
<div id="acara_lainnya-fields" class="hidden">...</div>
```

JavaScript will show/hide based on selected template's event_type.

**Question for you:** Should fields be organized in sections (e.g., "Detail Ulang Tahun", "Detail Acara") or just flat additional fields after common fields?

## Scope Boundaries

**In Scope:**
1. Clean up duplicate templates in database
2. Add category-specific form fields (ulang_tahun, acara_lainnya)
3. Add template preview modal/feature
4. Update views (create.blade.php, edit.blade.php)
5. Update controller validation
6. Update invitation-card component if needed to display new fields

**Out of Scope:**
- Backend analytics/reporting for new fields
- Admin panel to manage templates
- User-created custom templates
- Multi-language support for new fields
- Email notifications with new fields
- PDF export of invitations

## Open Questions Summary

Please answer these to finalize the plan:

**Q1:** Are there existing events using templates? Safe to truncate templates table?

**Q2:** Which specific fields for Ulang Tahun and Acara Lainnya? (See detailed list above)

**Q3:** Preview modal design - Option A (images), B (live component), or C (hybrid)?

**Q4:** Are proposed field names acceptable? Any additions?

**Q5:** Form sections organization - nested sections or flat list?

Once you answer these, I'll create a detailed implementation-ready plan with exact steps, file changes, and validation criteria.
