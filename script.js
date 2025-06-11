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

function openReservar() {
    obtenerTipoHab();
    obtenerMetodosPago();
    obtenerIdUsuario();
    document.getElementById('modalReserva').style.display = 'block';
}

// Funciones AJAX para habitaciones
function editarHabitacion(id) {
    console.log("Entro");
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
	var contenedor;
	contenedor = document.getElementById('contenido');
	fetch(abrir)
		.then(response => response.text())
		.then(data => contenedor.innerHTML=data);
}

function obtenerTipoHab() {
    fetch('tipoHabitacion.php')
        .then(response => response.text())
        .then(data => {
            document.querySelector('#tipoHab').innerHTML = data;
            document.querySelector('#habitacion').innerHTML = '';
        })
        .catch(error => console.error('Error:', error));
}

function obtenerHabitaciones() {
    const tipoHab_id = document.getElementById('tipoHab').value;
    fetch(`habitacion.php?id=${tipoHab_id}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#habitacion').innerHTML = data;
            calcularTotal();
        })
        .catch(error => console.error('Error:', error));
}

function obtenerMetodosPago() {
    fetch('metodos_pago.php')
        .then(response => response.text())
        .then(data => {
            document.querySelector('#metodo_pago').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
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
        .catch(error => console.error('Error:', error));
}

function calcularTotal() {
    const tipoHab = document.getElementById('tipoHab');
    const fechaInicio = document.getElementById('ingreso').value;
    const fechaFin = document.getElementById('salida').value;

    if (tipoHab.value && fechaInicio && fechaFin) {
        fetch(`calcular_total.php?tipo_hab=${tipoHab.value}&fecha_inicio=${fechaInicio}&fecha_fin=${fechaFin}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('total').value = `$${data.total}`;
                }
            })
            .catch(error => console.error('Error:', error));
    }
}

// Agregar event listeners para calcular total cuando cambien las fechas
document.addEventListener('DOMContentLoaded', function() {
    const fechaInicio = document.getElementById('ingreso');
    const fechaFin = document.getElementById('salida');
    
    if (fechaInicio && fechaFin) {
        fechaInicio.addEventListener('change', calcularTotal);
        fechaFin.addEventListener('change', calcularTotal);
    }
});

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
            if (data.redirect) {
                window.location.href = data.redirect;
            }
        } else {
            alert(data.message || 'Error al guardar la reserva');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar la reserva');
    });
}

