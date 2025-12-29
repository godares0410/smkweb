// Admin JavaScript

// Confirm delete
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('Yakin ingin menghapus?')) {
                e.preventDefault();
            }
        });
    });
});

