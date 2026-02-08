document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<span class="loading-spinner"></span> Processing...';
                submitBtn.classList.add('btn-loading');
            }
        });
    });
});
