// Menú lateral
function toggleMenu() {
    const sidebar = document.getElementById('sidebar');
    const content = document.getElementById('content');
    if (sidebar.style.left === "0px") {
      sidebar.style.left = "-250px";
      content.style.marginLeft = "0";
    } else {
      sidebar.style.left = "0px";
      content.style.marginLeft = "250px";
    }
}

// Búsqueda de empleados (clientes)
function searchEmployee() {
    const input = document.getElementById('searchInput');
    const filter = input.value.toLowerCase();
    const table = document.getElementById('employeeTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
      const cells = rows[i].getElementsByTagName('td');
      let match = false;

      for (let j = 0; j < cells.length; j++) {
        const text = cells[j].textContent || cells[j].innerText;
        if (text.toLowerCase().includes(filter)) {
          match = true;
          break;
        }
      }

      rows[i].style.display = match ? "" : "none";
    }
}

// Submenú CLIENTES
function toggleSubMenu() {
    const subMenu = document.getElementById('clientSubMenu');
    const container = document.querySelector('.submenu-container');

    const isOpen = subMenu.style.display === "flex";
    subMenu.style.display = isOpen ? "none" : "flex";

    // Agrega o quita la clase .open para girar la flechita ▼
    if (isOpen) {
      container.classList.remove("open");
    } else {
      container.classList.add("open");
    }
}

// Cierra el submenú si haces clic fuera
window.addEventListener('click', function (e) {
    const submenu = document.getElementById('clientSubMenu');
    const button = document.querySelector('.clients');
    const container = document.querySelector('.submenu-container');

    if (!submenu.contains(e.target) && !button.contains(e.target)) {
      submenu.style.display = "none";
      container.classList.remove("open");
    }
});

// Mostrar el modal de selección de tipo de cliente
function openClientTypeModal() {
    const modal = document.getElementById('clientTypeScreen');
    modal.classList.remove('hidden'); // Muestra el modal
}

function openClientTypeModa() {
    const modal = document.getElementById('clientTypeScree');
    modal.classList.remove('hidden'); // Muestra el modal
}

// Cerrar el modal de selección de tipo de cliente
function closeClientTypeScreen() {
    const modal = document.getElementById('clientTypeScreen');
    modal.classList.add('hidden'); // Oculta el modal
}

// Función que se llama cuando seleccionas un tipo de cliente
function selectClientType(type) {
    // Después de seleccionar el tipo de cliente, se muestra la opción para elegir entre "Natural" o "Jurídico"
    alert(`Seleccionaste el tipo de cliente: ${type}`);
    
    // Mostrar las opciones de "Natural" o "Jurídico"
    openClientNatureModal(type);
    closeClientTypeScreen(); // Cierra el modal después de la selección del tipo de cliente
}

// Abre el modal de "Natural" o "Jurídico"
function openClientNatureModal(type) {
    const modal = document.getElementById('clientNatureScreen');
    modal.classList.remove('hidden'); // Muestra el modal
    document.getElementById('clientTypeSelected').textContent = `Tipo de cliente: ${type}`;
}

// Cerrar el modal de "Natural" o "Jurídico"
function closeClientNatureModal() {
    const modal = document.getElementById('clientNatureScreen');
    modal.classList.add('hidden'); // Oculta el modal
}

// Función que se llama cuando seleccionas "Natural" o "Jurídico"
function selectClientNature(nature) {
    alert(`Seleccionaste que el cliente es: ${nature}`);
    closeClientNatureModal(); // Cierra el modal después de la selección de "Natural" o "Jurídico"
}
// Mostrar el modal de selección de tipo de cliente
function openClientTypeModal() {
    const modal = document.getElementById('clientTypeScreen');
    modal.classList.remove('hidden'); // Muestra el modal
}

// Cerrar el modal de selección de tipo de cliente
function closeClientTypeScreen() {
    const modal = document.getElementById('clientTypeScreen');
    modal.classList.add('hidden'); // Oculta el modal
}

// Función que se llama cuando seleccionas un tipo de cliente
function selectClientType(type) {
    // Si el tipo seleccionado es "Contribuyente", mostramos un submenú con "Natural" y "Jurídico"
    if (type === "Contribuyente") {
        openClientNatureSubMenu(type);
    } else {
        // Si es otro tipo de cliente, simplemente mostramos el tipo de cliente seleccionado
        alert(`Seleccionaste el tipo de cliente: ${type}`);
        closeClientTypeScreen(); // Cierra el modal después de la selección del tipo de cliente
    }
}

// Mostrar el submenú para seleccionar "Natural" o "Jurídico"
function openClientNatureSubMenu(type) {
    const modal = document.getElementById('clientNatureScreen');
    modal.classList.remove('hidden'); // Muestra el modal
    document.getElementById('clientTypeSelected').textContent = `Seleccionaste el tipo de cliente: ${type}`;

    // Desplegar opciones para "Natural" o "Jurídico"
    const natureButtons = document.getElementById('natureButtons');
    natureButtons.classList.remove('hidden'); // Muestra las opciones de "Natural" y "Jurídico"
}

// Cerrar el modal de "Natural" o "Jurídico"
function closeClientNatureModal() {
    const modal = document.getElementById('clientNatureScreen');
    modal.classList.add('hidden'); // Oculta el modal
    const natureButtons = document.getElementById('natureButtons');
    natureButtons.classList.add('hidden'); // Oculta el submenú "Natural" o "Jurídico"
}

// Función que se llama cuando seleccionas "Natural" o "Jurídico"
function selectClientNature(nature) {
    alert(`Seleccionaste que el cliente es: ${nature}`);
    closeClientNatureModal(); // Cierra el modal después de la selección de "Natural" o "Jurídico"
}
// Función que se llama cuando seleccionas un tipo de cliente
function selectClientType(type) {
    // Si el tipo seleccionado es "Contribuyente" o "Sujeto Excluido", mostramos un submenú con opciones adicionales
    if (type === "Contribuyente" || type === "Sujeto Excluido") {
        openClientNatureSubMenu(type);
    } else {
        // Si es otro tipo de cliente, simplemente mostramos el tipo de cliente seleccionado
        alert(`Seleccionaste el tipo de cliente: ${type}`);
        closeClientTypeScreen(); // Cierra el modal después de la selección del tipo de cliente
    }
}

// Mostrar el submenú para seleccionar "Natural", "Jurídico", "ONG" o "Instituciones del gobierno"
function openClientNatureSubMenu(type) {
    const modal = document.getElementById('clientNatureScreen');
    modal.classList.remove('hidden'); // Muestra el modal
    document.getElementById('clientTypeSelected').textContent = `Seleccionaste el tipo de cliente: ${type}`;

    // Desplegar opciones dependiendo del tipo de cliente
    const natureButtons = document.getElementById('natureButtons');
    natureButtons.classList.remove('hidden'); // Muestra las opciones de "Natural", "Jurídico", "ONG" e "Instituciones del gobierno"

    // Dependiendo del tipo de cliente, configuramos las opciones del submenú
    let options = '';
    if (type === "Contribuyente") {
        options = `
            <button class="client-type-button" onclick="window.location.href='../form-ctb-ntl/ctb-ntl.html'">Natural</button>
            <button class="client-type-button" onclick="window.location.href='../form-ctb-jrc/ctb-jrc.html'">Jurídico</button>
        `;
    } else if (type === "Sujeto Excluido") {
        options = `
            <button class="client-type-button" onclick="window.location.href='../form-sjx-ntl/sjx-ntl.html'">Natural</button>
            <button class="client-type-button" onclick="window.location.href='../form-sjx-jrc/sjx-jrc.html'">Jurídico</button>
            <button class="client-type-button" onclick="window.location.href='../form-sjx-ong/sjx-ong.html'">ONG</button>
            <button class="client-type-button" onclick="window.location.href='../form-sjx-instituto/sjx-instituto.html'">Instituciones del Gobierno</button>
         <button class="client-type-button" onclick="window.location.href='../form-sjx-instituto-NX/sjx-instituto-NX.html'">Instituciones del Gobierno (NO EXENTAS)</button>
        `;
    }

    // Insertar las opciones en el modal
    natureButtons.innerHTML = options;
}

// Cerrar el modal de "Natural", "Jurídico", "ONG", "Instituciones del Gobierno"
function closeClientNatureModal() {
    const modal = document.getElementById('clientNatureScreen');
    modal.classList.add('hidden'); // Oculta el modal
    const natureButtons = document.getElementById('natureButtons');
    natureButtons.classList.add('hidden'); // Oculta las opciones "Natural", "Jurídico", "ONG", "Instituciones del Gobierno"
}

// Función que se llama cuando seleccionas una opción dentro del submenú
function selectClientNature(nature) {
    alert(`Seleccionaste que el cliente es: ${nature}`);
    closeClientNatureModal(); // Cierra el modal después de la selección
}
