<script>
    /**
     * Global Financial Formatter for Koperasi Ugoro
     * Automatically adds thousand separators (dots) while typing.
     */
    document.addEventListener('DOMContentLoaded', function() {
        const rupiahInputs = document.querySelectorAll('.format-rupiah');
        
        rupiahInputs.forEach(input => {
            // Format on initial load if needed
            if (input.value) {
                input.value = formatNumber(input.value);
            }

            input.addEventListener('input', function(e) {
                // Get original cursor position
                let cursorPosition = this.selectionStart;
                let originalLength = this.value.length;

                // Format the value
                let formattedValue = formatNumber(this.value);
                this.value = formattedValue;

                // Adjust cursor position after formatting
                let newLength = this.value.length;
                cursorPosition = cursorPosition + (newLength - originalLength);
                this.setSelectionRange(cursorPosition, cursorPosition);
            });
        });

        function formatNumber(n) {
            // Remove all non-digits
            let val = n.replace(/\D/g, "");
            // Add dots every 3 digits
            return val.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    });

    /**
     * Universal Confirmation Modal Trigger
     * Listens for clicks on elements with .js-univ-confirm
     */
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.js-univ-confirm');
        if (!btn) return;

        // If it's a link or submit button, prevent default to wait for confirmation
        if (btn.tagName === 'A' || btn.getAttribute('type') === 'submit') {
            e.preventDefault();
        }

        if (typeof showConfirmModal === 'function') {
            showConfirmModal({
                title: btn.dataset.title,
                description: btn.dataset.desc,
                action: btn.dataset.action,
                formId: btn.dataset.formId,
                confirmLabel: btn.dataset.confirmLabel,
                confirmText: btn.dataset.confirmText,
                type: btn.dataset.type || 'danger',
                method: btn.dataset.method || 'DELETE'
            });
        } else {
            console.error('Kritis: showConfirmModal tidak ditemukan! Pastikan confirm_modal.blade.php disertakan.');
            // Fallback to native confirm if modal fails to load
            if (confirm(btn.dataset.title || 'Apakah Anda yakin?')) {
                const action = btn.dataset.action;
                if (action && action !== '#') {
                    window.location.href = action;
                }
            }
        }
    }, true); // Use capture phase to ensure it runs even if other listeners exist
    /**
     * Auto Loader on Form Submission
     */
    document.addEventListener('submit', function(e) {
        // Find if the trigger button has no-loader class or specific data
        const submitBtn = e.submitter;
        if (submitBtn && (submitBtn.classList.contains('no-loader') || submitBtn.closest('.no-loader'))) return;
        
        if (e.target.tagName === 'FORM' && !e.target.classList.contains('no-loader')) {
            showLoader('Sedang memproses permintaan Anda...');
        }
    });

    /**
     * Auto Loader on Page Navigation (Link Clicks)
     */
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        // Only trigger for internal links, not targets, not hashes, not downloads
        if (link && 
            link.href && 
            !link.target && 
            !link.href.startsWith('javascript:') && 
            !link.href.includes('#') &&
            !link.getAttribute('download') &&
            !link.classList.contains('no-loader') &&
            link.hostname === window.location.hostname &&
            !e.ctrlKey && !e.shiftKey && !e.metaKey && !e.altKey) {
            
            showLoader('Memuat halaman...');
        }
    });
</script>
