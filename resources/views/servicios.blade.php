<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Servicios - Lavandería Gonzalo</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            align-items: center;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #1A237E;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .form-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            border: 1px solid #000;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            background-color: #fff;
            width: 50%;
            margin-bottom: 20px;
        }
        .form-container input, .form-container select {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container button {
            width: 80%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 4px;
            color: #FFF;
            background-color: #009688;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #00796B;
        }
        .nav-buttons {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 200px;
            margin-bottom: 20px;
        }
        .nav-button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #BDBDBD;
            background-color: #1A237E;
            color: #FFF;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }
        .nav-button:hover {
            background-color: #009688;
            color: #FFF;
        }
        .edit-container {
            display: none;
            margin-bottom: 20px;
        }
        .edit-row {
            display: none;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="nav-buttons">
        <button class="nav-button" onclick="window.location.href='/venta'">Ventas</button>
        <button class="nav-button" onclick="window.location.href='/registros'">Registros</button>
    </div>

    <h2>Gestión de Servicios</h2>
    <div class="form-container">
        <input type="text" id="serviceName" placeholder="Nombre del Servicio">
        <input type="number" id="servicePrice" placeholder="Precio">
        <select id="serviceType">
            <option value="Kilogramo(s)">Kilogramo(s)</option>
            <option value="Pieza(s)">Pieza(s)</option>
            <option value="Par(es)">Par(es)</option>
        </select>
        <button onclick="addService()">Agregar Servicio</button>
    </div>

    <table id="servicesTable">
        <thead>
            <tr>
                <th>Servicio</th>
                <th>Precio</th>
                <th>Tipo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        var services = [];

        document.addEventListener("DOMContentLoaded", function() {
            loadServices();
        });

        function loadServices() {
            fetch('/servicios')
                .then(response => response.json())
                .then(data => {
                    services = data;
                    var servicesTable = document.getElementById('servicesTable').getElementsByTagName('tbody')[0];
                    servicesTable.innerHTML = '';
                    services.forEach((service, index) => {
                        var row = servicesTable.insertRow();
                        row.id = `serviceRow${index}`;
                        row.insertCell(0).innerHTML = service.tipo_servicio;
                        row.insertCell(1).innerHTML = service.precio_por_unidad;
                        row.insertCell(2).innerHTML = service.tipo;

                        var actionsCell = row.insertCell(3);
                        var editButton = document.createElement('button');
                        editButton.innerHTML = 'Editar';
                        editButton.onclick = function() { showEditForm(index); };
                        actionsCell.appendChild(editButton);

                        var deleteButton = document.createElement('button');
                        deleteButton.innerHTML = 'Eliminar';
                        deleteButton.onclick = function() { deleteService(service.id); };
                        actionsCell.appendChild(deleteButton);

                        var editRow = servicesTable.insertRow();
                        editRow.classList.add('edit-container');
                        editRow.id = `editRow${index}`;
                        var editCell = editRow.insertCell(0);
                        editCell.colSpan = 4;
                        editCell.innerHTML = `
                            <input type="hidden" id="editServiceId${index}" value="${service.id}">
                            <input type="text" id="editServiceName${index}" value="${service.tipo_servicio}" placeholder="Nombre del Servicio">
                            <input type="number" id="editServicePrice${index}" value="${service.precio_por_unidad}" placeholder="Precio">
                            <select id="editServiceType${index}">
                                <option value="Kilogramo(s)" ${service.tipo === 'Kilogramo(s)' ? 'selected' : ''}>Kilogramo(s)</option>
                                <option value="Pieza(s)" ${service.tipo === 'Pieza(s)' ? 'selected' : ''}>Pieza(s)</option>
                                <option value="Par(es)" ${service.tipo === 'Par(es)' ? 'selected' : ''}>Par(es)</option>
                            </select>
                            <button onclick="updateService(${index})">Guardar</button>
                            <button onclick="cancelEdit(${index})">Cancelar</button>
                        `;
                    });
                });
        }

        function addService() {
            var serviceName = document.getElementById('serviceName').value;
            var servicePrice = document.getElementById('servicePrice').value;
            var serviceType = document.getElementById('serviceType').value;
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (serviceName === '' || servicePrice === '' || serviceType === '') {
                alert('No se permiten valores vacíos');
                return;
            }

            fetch('/servicios', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    tipo_servicio: serviceName,
                    precio_por_unidad: servicePrice,
                    tipo: serviceType
                })
            })
            .then(response => response.json())
            .then(service => {
                loadServices();
                document.getElementById('serviceName').value = '';
                document.getElementById('servicePrice').value = '';
                document.getElementById('serviceType').value = 'Kilogramo(s)'; // Reset the select to default value
            })
            .catch(error => console.error('Error:', error));
        }

        function showEditForm(index) {
            document.querySelectorAll('.edit-row').forEach(row => row.style.display = 'none');
            document.getElementById(`editRow${index}`).style.display = 'table-row';
        }

        function updateService(index) {
            var serviceId = document.getElementById(`editServiceId${index}`).value;
            var serviceName = document.getElementById(`editServiceName${index}`).value;
            var servicePrice = document.getElementById(`editServicePrice${index}`).value;
            var serviceType = document.getElementById(`editServiceType${index}`).value;
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (serviceName === '' || servicePrice === '' || serviceType === '') {
                alert('No se permiten valores vacíos');
                return;
            }

            fetch(`/servicios/${serviceId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    tipo_servicio: serviceName,
                    precio_por_unidad: servicePrice,
                    tipo: serviceType
                })
            })
            .then(response => response.json())
            .then(() => {
                loadServices();
            })
            .catch(error => console.error('Error:', error));
        }

        function deleteService(id) {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/servicios/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            })
            .then(response => response.json())
            .then(() => {
                loadServices();
            })
            .catch(error => console.error('Error:', error));
        }

        function cancelEdit(index) {
            document.getElementById(`editRow${index}`).style.display = 'none';
        }
    </script>
</body>
</html>
