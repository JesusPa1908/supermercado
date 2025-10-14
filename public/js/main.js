document.addEventListener('DOMContentLoaded', function() {
    // Auto-ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(() => {
                alert.remove();
            }, 500);
        }, 5000);
    });

    const form = document.getElementById('productoForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const nombre = document.getElementById('nombre').value.trim();
            const precio = document.getElementById('precio').value;

            if (nombre === '') {
                e.preventDefault();
                alert('El nombre del producto es obligatorio');
                return false;
            }

            if (precio === '' || precio < 0) {
                e.preventDefault();
                alert('El precio debe ser un valor válido mayor o igual a 0');
                return false;
            }
        });
    }

    // Confirmar eliminación
    const deleteButtons = document.querySelectorAll('.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas eliminar este producto?\nEsta acción no se puede deshacer.')) {
                e.preventDefault();
            }
        });
    });

    // Resaltar fila de tabla
    const tableRows = document.querySelectorAll('.table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f1f5f9';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });

    // Formatear precio
    const precioInput = document.getElementById('precio');
    if (precioInput) {
        precioInput.addEventListener('blur', function() {
            if (this.value !== '') {
                this.value = parseFloat(this.value).toFixed(2);
            }
        });
    }
});

