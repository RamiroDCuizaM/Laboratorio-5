// Funciones para manejar modales
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'flex';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.style.display = 'none';
    }
}

// Funciones AJAX para habitaciones
function editarHabitacion(id) {
    fetch(`get_habitacion.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_id').value = data.id;
            document.getElementById('edit_numero').value = data.numero;
            document.getElementById('edit_piso').value = data.piso;
            document.getElementById('edit_tipohabitacion_id').value = data.tipohabitacion_id;
            openModal('modalEditarHabitacion');
        });
}

function eliminarHabitacion(id) {
    if (confirm('¿Está seguro de eliminar esta habitación?')) {
        fetch(`eliminar.php?id=${id}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar la habitación');
            }
        });
    }
}

function guardarHabitacion(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    
    fetch('guardar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al guardar la habitación');
        }
    });
}

// Funciones para manejo de imágenes
function editarImagen(habitacionId, imagenId) {
    fetch(`get_imagen.php?id=${imagenId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edit_imagen_id').value = data.id;
            document.getElementById('edit_habitacion_id').value = habitacionId;
            document.getElementById('imagen_preview').src = `imagesHotel/${data.fotografia}`;
            openModal('modalEditarImagen');
        });
}

function eliminarImagen(imagenId) {
    if (confirm('¿Está seguro de eliminar esta imagen?')) {
        fetch(`eliminar_imagen.php?id=${imagenId}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar la imagen');
            }
        });
    }
}

function guardarImagen(event) {
    event.preventDefault();
    const formData = new FormData(event.target);
    
    fetch('guardar_imagen.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al guardar la imagen');
        }
    });
}

// Preview de imagen antes de subir
function previewImage(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagen_preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
} 