const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
    event.preventDefault();

    const nombreUsuarioInput = document.getElementById('nombreUsuario');
    const contrasenaInput = document.getElementById('contrasena');

    // Verificar si los elementos existen
    if (!nombreUsuarioInput || !contrasenaInput) {
        alert("No se pudieron encontrar los campos de nombre de usuario o contraseña.");
        return;
    }

    const nombreUsuario = nombreUsuarioInput.value.trim();
    const contrasena = contrasenaInput.value.trim();

    // Validar si los campos están vacíos
    if (nombreUsuario === '' || contrasena === '') {
        alert('Por favor, ingresa nombre de usuario y contraseña.');
        return;
    }

    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Iniciando sesión...';

    // Enviar los datos al servidor usando fetch
    fetch('mod-inicio/ctr_inicio.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `nombreUsuario=${encodeURIComponent(nombreUsuario)}&contrasena=${encodeURIComponent(contrasena)}`
    })
    .then(response => response.text())
    .then(data => {
        submitButton.disabled = false;
        submitButton.textContent = 'Iniciar Sesión';

        // Si la respuesta es 'success', redirigir
        if (data === 'success') {
            setTimeout(() => {
                window.location.href = 'mod-menu/menu.html';  // Redirección correcta
            }, 1000);  // Espera 1 segundo antes de redirigir
        } else {
            alert('Nombre de usuario o contraseña incorrectos.');  // Solo alerta si es error
        }
    })
    .catch(error => {
        submitButton.disabled = false;
        submitButton.textContent = 'Iniciar Sesión';
        console.error('Error:', error);
        alert('Ocurrió un error al intentar iniciar sesión. Intenta nuevamente más tarde.');
    });
});
