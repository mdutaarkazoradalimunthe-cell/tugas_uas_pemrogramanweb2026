# Plan: Add Category Tabs for Template Selection

## Goal

Add category tabs (Pernikahan / Ulang Tahun) to template selection page so users see only relevant templates for their event type.

## Decisions Made

✅ **Default tab:** Pernikahan  
✅ **Tab style:** Horizontal pill-style buttons with count display  
✅ **Show count:** Yes - `Pernikahan (3)` format  
✅ **Implementation:** Hardcoded tabs (scalable for 3-5 categories)  
✅ **Switching:** Client-side JavaScript filtering (fast, no reload)  
✅ **Mobile:** Same horizontal layout (2 tabs fit well)

## Changes Required

### File: `resources/views/events/create.blade.php`

#### Change 1: Add Category Tab Pills (after line 30)

Insert after `<p class="text-sm text-ink/50">Pilih template yang sesuai dengan jenis acara Anda.</p>`:

```blade
{{-- Category Tabs --}}
<div class="flex justify-center gap-3 mb-8">
    <button type="button" 
            onclick="filterTemplates('pernikahan')" 
            id="tab-pernikahan"
            class="tab-category px-6 py-2 rounded-full text-sm font-medium transition-colors border-2 bg-evergreen text-paper border-evergreen">
        Pernikahan ({{ $templates->where('event_type', 'pernikahan')->count() }})
    </button>
    <button type="button" 
            onclick="filterTemplates('ulang_tahun')" 
            id="tab-ulang_tahun"
            class="tab-category px-6 py-2 rounded-full text-sm font-medium transition-colors border-2 border-mist/60 text-ink/60 hover:border-ink/40">
        Ulang Tahun ({{ $templates->where('event_type', 'ulang_tahun')->count() }})
    </button>
</div>
```

#### Change 2: Add Data Attribute to Template Cards (line ~46)

Find:
```blade
<div class="border border-mist/60 rounded-xl overflow-hidden transition-colors {{ $isWeddingTemplate ? 'hover:border-evergreen/40' : 'hover:border-blush/40' }}">
```

Replace with:
```blade
<div class="border border-mist/60 rounded-xl overflow-hidden transition-colors {{ $isWeddingTemplate ? 'hover:border-evergreen/40' : 'hover:border-blush/40' }}" 
     data-template-category="{{ $template->event_type }}">
```

#### Change 3: Add JavaScript Filter Function (inside `@push('scripts')` section)

Add at the **beginning** of the `<script>` block (before `let selectedEventType = ...`):

```javascript
let activeCategory = 'pernikahan';

function filterTemplates(category) {
    activeCategory = category;
    
    // Update tab active state
    document.querySelectorAll('.tab-category').forEach(tab => {
        const isActive = tab.id === 'tab-' + category;
        if (isActive) {
            // Active state with category color
            if (category === 'pernikahan') {
                tab.className = 'tab-category px-6 py-2 rounded-full text-sm font-medium transition-colors border-2 bg-evergreen text-paper border-evergreen';
            } else {
                tab.className = 'tab-category px-6 py-2 rounded-full text-sm font-medium transition-colors border-2 bg-blush text-white border-blush';
            }
        } else {
            // Inactive state
            tab.className = 'tab-category px-6 py-2 rounded-full text-sm font-medium transition-colors border-2 border-mist/60 text-ink/60 hover:border-ink/40';
        }
    });
    
    // Show/hide templates
    document.querySelectorAll('[data-template-category]').forEach(card => {
        if (card.dataset.templateCategory === category) {
            card.classList.remove('hidden');
        } else {
            card.classList.add('hidden');
        }
    });
}
```

#### Change 4: Initialize Filter on Page Load

Inside the existing `document.addEventListener('DOMContentLoaded', () => {` block, add as first line:

```javascript
document.addEventListener('DOMContentLoaded', () => {
    filterTemplates('pernikahan'); // ADD THIS LINE
    updatePreviewVisibility();
    syncAllFields();
    // ... rest of existing code
});
```

### File: `resources/views/events/edit.blade.php`

Apply the same 4 changes to edit page for consistency when user changes template on edit flow.

**Note:** Edit page already has similar structure, apply identical changes at corresponding lines.

## Implementation Checklist

- [ ] Add tab pills HTML to `events/create.blade.php` after subheading
- [ ] Add `data-template-category` attribute to template cards in `events/create.blade.php`
- [ ] Add `filterTemplates()` JavaScript function to `events/create.blade.php`
- [ ] Initialize filter on DOMContentLoaded in `events/create.blade.php`
- [ ] Apply same 4 changes to `events/edit.blade.php`
- [ ] Test: Load create page → default Pernikahan tab active, only 3 templates visible
- [ ] Test: Click Ulang Tahun tab → switch smooth, 5 templates visible
- [ ] Test: Click Pernikahan again → back to 3 templates
- [ ] Test: Select template → proceed to layout selection (functionality unchanged)
- [ ] Test: Mobile viewport → tabs horizontal and usable
- [ ] Clear Blade cache: `php artisan view:clear`
- [ ] Build assets: `npm run build`

## Edge Cases Handled

1. **Empty category:** Not applicable (both have templates), but if needed: tab shows disabled state
2. **Single template:** Grid responsive handles single item gracefully
3. **Tab color consistency:** Pernikahan=evergreen, Ulang Tahun=blush (matches existing button colors)
4. **Form validation error:** Filter reinitializes to default (pernikahan) on page reload - acceptable UX

## Validation Steps

1. Open `/events/create` → Pernikahan tab active (filled evergreen), Ulang Tahun inactive (outlined gray)
2. Grid shows 3 pernikahan templates only
3. Click "Ulang Tahun" tab → tab turns filled blush, grid shows 5 ulang tahun templates
4. Click "Pernikahan" tab → back to 3 templates, tab evergreen
5. Select any template → click next → layout selection works (no regression)
6. Test on mobile (< 768px) → tabs fit horizontally, clickable
7. Browser console → no JavaScript errors

## Risks

**Low risk:** All changes are additive. Existing functionality unchanged. JavaScript filtering is isolated.

## Rollback

If issues occur:
```bash
git checkout resources/views/events/create.blade.php
git checkout resources/views/events/edit.blade.php
php artisan view:clear
```

## Future Scalability

To add new event type (e.g., "seminar"):

1. Add to `TemplateSeeder`: create templates with `event_type = 'seminar'`
2. Add tab button in view:
   ```blade
   <button type="button" onclick="filterTemplates('seminar')" id="tab-seminar" class="tab-category ...">
       Seminar ({{ $templates->where('event_type', 'seminar')->count() }})
   </button>
   ```
3. Add color mapping in `filterTemplates()` if-else for active state
4. Decision: Keep pernikahan as default or change based on analytics

Supports 3-5 categories comfortably with current horizontal tab design.

## Out of Scope

- Server-side category filtering
- Search/filter by template name
- Dynamic tab generation from DB
- Analytics tracking
- "Show All" option
- Remembering user's last selected category

## No Controller Changes

`EventController@create` already passes all templates. No backend changes needed.
