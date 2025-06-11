// Funciones para manejar modales
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Cerrar modal al hacer clic fuera
window.onclick = function(event) {
    if (event.target.classList.contains('modal-R')) {
        event.target.style.display = 'none';
    }
}

var modal = document.getElementById('modalReserva');

function openReservar(){
    combinada();
    modal.style.display = 'block';
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

function cargarContenido(abrir) {
    var contenedor = document.getElementById('contenido');
    fetch(abrir)
        .then(response => response.text())
        .then(data => contenedor.innerHTML = data);
}

function obtenerTipoHab() {
    fetch("tipoHabitacion.php")
        .then(response => response.text())
        .then(data => {
            document.querySelector('#tipoHab').innerHTML = data;
            document.querySelector('#habitacion').innerHTML = '';
        });
}

function obtenerHabitaciones() {
    var tipoHab_id = document.getElementById('tipoHab').value;
    fetch(`habitacion.php?id=${tipoHab_id}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#habitacion').innerHTML = data;
            calcularMontoTotal();
        });
}

function obtenerMetodosPago() {
    fetch("metodos_pago.php")
        .then(response => response.text())
        .then(data => {
            document.querySelector('#metodo_pago').innerHTML = data;
        });
}

function obtenerIdUsuario() {
    fetch('get_usuario_id.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('usuario').value = data.id;
            } else {
                alert("No se pudo obtener el ID del usuario.");
            }
        })
        .catch(error => {
            console.error('Error al obtener ID de usuario:', error);
        });
}

function calcularMontoTotal() {
    const fechaInicio = new Date(document.getElementById('ingreso').value);
    const fechaFin = new Date(document.getElementById('salida').value);
    const habitacionId = document.getElementById('habitacion').value;
    
    if (fechaInicio && fechaFin && habitacionId) {
        const dias = Math.ceil((fechaFin - fechaInicio) / (1000 * 60 * 60 * 24));
        if (dias > 0) {
            fetch(`get_precio_habitacion.php?id=${habitacionId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const montoTotal = dias * data.precio;
                        document.getElementById('monto_total').value = `$${montoTotal.toFixed(2)}`;
                    }
                });
        }
    }
}

function combinada() {
    obtenerTipoHab();
    obtenerIdUsuario();
    obtenerMetodosPago();
}

function guardarReserva(event) {
    event.preventDefault();
    const formData = new FormData(document.querySelector('#form-Reserva'));

    fetch("guardarReserva.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Reserva registrada correctamente');
            closeModal('modalReserva');
            document.querySelector('#form-Reserva').reset();
            document.getElementById('monto_total').value = '';
        } else {
            alert(data.message || 'Error al guardar la reserva');
        }
    })
    .catch(error => {
        console.error('Error al guardar la reserva:', error);
        alert('Error al guardar la reserva');
    });
}

// Event listeners para calcular monto total
document.addEventListener('DOMContentLoaded', function() {
    const fechaInicio = document.getElementById('ingreso');
    const fechaFin = document.getElementById('salida');
    const habitacion = document.getElementById('habitacion');

    if (fechaInicio) fechaInicio.addEventListener('change', calcularMontoTotal);
    if (fechaFin) fechaFin.addEventListener('change', calcularMontoTotal);
    if (habitacion) habitacion.addEventListener('change', calcularMontoTotal);
});

