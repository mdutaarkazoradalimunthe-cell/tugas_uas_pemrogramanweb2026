@props(['id' => 'preview-modal'])

<div id="{{ $id }}" class="hidden fixed inset-0 bg-ink/50 z-50 flex items-center justify-center p-4" onclick="closeModal('{{ $id }}')">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl" onclick="event.stopPropagation()">
        <div class="sticky top-0 bg-white border-b border-mist/60 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-semibold text-ink">Preview Template</h3>
            <button type="button" onclick="closeModal('{{ $id }}')" class="text-ink/40 hover:text-ink transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="{{ $id }}-content" class="p-6">
            <!-- Content will be injected here -->
        </div>
    </div>
</div>

<script>
function openModal(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.style.overflow = '';
}
</script>
