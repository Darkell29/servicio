<!DOCTYPE html>
<html>
<head>
    <title>Lavandería S.O.S</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gochi+Hand&family=Sedgwick+Ave&display=swap" rel="stylesheet">
    <style>
        body {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            grid-template-rows: 1fr 3fr;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
            background-color: #f0f1f1;
        }
        button.add-button:hover {
            background-color: #3a85c6;
            color: #FFF;
        }

        .logo-container {
            grid-column: 1;
            grid-row: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fad6e4;
            color: #FFF;
            padding: 20px;
        }
        .logo-container img {
            width: 400px;
            height: 400px;
        }
        .table-container {
            grid-column: 1;
            grid-row: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #fad6e4;
            color: #441e54;
            padding: 20px;
        }
        .table-container table {
            width: 100%;
            background-color: #f0f1f1;
        }
        .table-container table, th, td {
            border: 1px solid #1baab8;
            border-collapse: collapse;
            padding: 10px;
            text-align: center;
            cursor: pointer;
        }
        .form-container {
            grid-column: 2;
            grid-row: 1 / span 2;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            background-color: #fad6e4;
            color: #441e54;
            padding: 20px;
        }
        /* Cambios en el CSS */
        .form-container h2 {
            margin-bottom: 0px;
            color: #ef9fc3;
            font-size: 40px; /* Tamaño de la palabra "Lavandería" */
            text-align: center;
        }

        .form-container .sos {
            color: #3a85c6;
            font-size: 100px; /* Tamaño de "S.O.S" */
            font-weight: bold;
            font-family: "Sedgwick Ave", cursive;

        }

        .form-container .full-input, .form-container button {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
        }
        .form-container .half-input {
            width: 38%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 4px;
        }
        .form-container button {
            margin-top: 20px;
            color: #FFF;
            background-color: #622b7a;
        }
        .image-container {
            grid-column: 3;
            grid-row: 1 / span 2;
            background-image: url('imagenes/mujer.jpg');
            background-size: cover;
            background-position: center;
        }
        .error {
            color: red;
            font-size: small;
        }
        .items-table-container {
            grid-column: 3;
            grid-row: 1 / span 2;
            display: none;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            background-color: #f0f1f1;
            padding: 20px;
            height: 100%;
        }
        .items-table-wrapper {
            flex: 1;
            overflow-y: auto;
            width: 100%;
            max-height: calc(100% - 200px);
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #f0f1f1;
        }
        .items-table th, .items-table td {
            border: 1px solid #1baab8;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            background-color: #622b7a;
            color: #FFF;
        }
        .items-table tr:nth-child(even) {
            background-color: #fad6e4;
        }
        .nav-buttons {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: 200px;
            margin-bottom: 20px;
        }
        .nav-button, .record-button, .print-button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #a3b3c1;
            background-color: #ef9fc3;
            color: #441e54;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }
        .nav-button:hover, .record-button:hover, .print-button:hover {
            background-color: #3a85c6;
            color: #FFF;
        }
        .options-container {
            display: none;
            position: absolute;
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 10px;
            z-index: 1000;
        }
        .options-container button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-bottom: 5px;
            border: none;
            background-color: #3a85c6;
            color: #FFF;
            cursor: pointer;
        }
        .options-container button:hover {
            background-color: #a3b3c1;
        }
        .total-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: -40px;
        }
        .total-container .total-label {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .total-container .print-controls {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 80%;
        }
        .total-container .print-controls select,
        .total-container .print-controls input[type="date"],
        .total-container .print-controls input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="logo-container">
        <img src="imagenes/logo.png" alt="Logo">
    </div>
    <div class="table-container">
        <table>
            <!-- Aquí puedes agregar más filas si es necesario -->
        </table>
        <div class="nav-buttons">
            <button class="nav-button" onclick="window.location.href='/registros'">Registros</button>
            <form method="POST" action="{{ route('misservi') }}" style="width: 100%;">
                @csrf
                <button type="submit" class="nav-button" id="recordButton">Gestión de Servicios</button>
            </form>
        </div>
    </div>
        <!-- Cambios en el HTML -->
        <div class="form-container" id="formContainer">
        <h2>Lavandería<br><span class="sos">S.O.S</span></h2>
        <input type="text" id="name" class="full-input" placeholder="Nombre">
        <div style="display: flex; justify-content: space-between; width: 80%;">
            <input type="text" id="phone" class="half-input" placeholder="Teléfono">
            <select id="serviceType" class="half-input" onchange="updateKilogramsPlaceholder()">
                <!-- Los servicios serán cargados dinámicamente -->
            </select>
        </div>
            <div style="display: flex; justify-content: space-between; width: 80%;">
                <input type="number" id="kilograms" class="half-input" placeholder="Cantidad" oninput="calculateTotal()">
                <input type="text" id="total" class="half-input" placeholder="Total" value="Total" readonly>
            </div>
            <button class="add-button" onclick="addItem()">Agregar</button>
        </div>

    <div class="image-container" id="imageContainer"></div>
    <div class="items-table-container" id="itemsTableContainer">
        <div class="items-table-wrapper">
            <table class="items-table" id="itemsTable">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <div class="total-container">
            <div class="total-label">Total: <span id="totalSum">0.00 MXN</span></div>
            <div class="print-controls">
                <input type="date" id="deliveryDate" placeholder="Fecha de entrega">
                <select id="advanceOption" onchange="toggleAdvanceInput()">
                    <option value="ninguno">Ninguno</option>
                    <option value="anticipo">Anticipo</option>
                    <option value="pagado">Pagado</option>
                </select>
                <input type="number" id="advanceAmount" placeholder="Monto del anticipo" style="display: none;" oninput="validateAdvanceAmount(this)">
                <button class="print-button" onclick="printTicket()">Imprimir</button>
            </div>
        </div>
    </div>
    <div id="optionsContainer" class="options-container"></div>
    <script>
        var items = [];
        var services = [];
        var currentIndex = null;

        document.addEventListener("DOMContentLoaded", function() {
            loadServices();
            setDefaultDeliveryDate();
        });

        function loadServices() {
            fetch('/servicios')
                .then(response => response.json())
                .then(data => {
                    services = data;
                    var serviceTypeSelect = document.getElementById('serviceType');
                    serviceTypeSelect.innerHTML = '';
                    services.forEach(service => {
                        var option = document.createElement('option');
                        option.value = service.tipo_servicio;
                        option.text = service.tipo_servicio;
                        option.setAttribute('data-price', service.precio_por_unidad);
                        option.setAttribute('data-tipo', service.tipo);
                        serviceTypeSelect.appendChild(option);
                    });
                    updateKilogramsPlaceholder();
                });
        }

        function updateKilogramsPlaceholder() {
            var serviceType = document.getElementById('serviceType').value;
            var tipo = document.querySelector(`#serviceType option[value="${serviceType}"]`).getAttribute('data-tipo');
            document.getElementById('kilograms').placeholder = tipo ? tipo : 'Cantidad';
        }

        function addItem() {
            var name = document.getElementById('name').value;
            var phone = document.getElementById('phone').value;
            var serviceType = document.getElementById('serviceType').value;
            var kilograms = parseFloat(document.getElementById('kilograms').value);
            var price = parseFloat(document.querySelector(`#serviceType option[value="${serviceType}"]`).getAttribute('data-price'));
            var tipo = document.querySelector(`#serviceType option[value="${serviceType}"]`).getAttribute('data-tipo');
            var total = price * kilograms;

            if (!name || !phone || !serviceType || kilograms <= 0 || isNaN(kilograms)) {
                alert('No se permiten valores vacíos o 0 kilogramos');
                return;
            }

            items.push({
                serviceType: serviceType,
                kilograms: kilograms,
                total: total,
                tipo: tipo
            });

            updateItemsTable();
            document.getElementById('serviceType').value = services[0].tipo_servicio;
            document.getElementById('kilograms').value = '';
            document.getElementById('total').value = 'Total';
        }

        function updateItemsTable() {
            var itemsTableContainer = document.getElementById('itemsTableContainer');
            var imageContainer = document.getElementById('imageContainer');

            if (items.length > 0) {
                itemsTableContainer.style.display = 'flex';
                imageContainer.style.display = 'none';
            } else {
                itemsTableContainer.style.display = 'none';
                imageContainer.style.display = 'block';
            }

            var tableBody = document.getElementById('itemsTable').getElementsByTagName('tbody')[0];
            tableBody.innerHTML = '';

            var totalSum = 0;
            for (var i = 0; i < items.length; i++) {
                var row = tableBody.insertRow(-1);
                row.insertCell(0).innerHTML = items[i].serviceType;
                row.insertCell(1).innerHTML = items[i].kilograms + ' ' + items[i].tipo;
                row.insertCell(2).innerHTML = items[i].total.toFixed(2) + ' MXN';
                row.setAttribute('data-index', i);
                row.onclick = function() {
                    toggleOptions(this.getAttribute('data-index'));
                };
                totalSum += items[i].total;
            }
            document.getElementById('totalSum').innerText = totalSum.toFixed(2) + ' MXN';
            document.getElementById('total').value = totalSum.toFixed(2) + ' MXN';
        }

        function calculateTotal() {
            var serviceType = document.getElementById('serviceType').value;
            var kilograms = document.getElementById('kilograms').value;
            var price = document.querySelector(`#serviceType option[value="${serviceType}"]`).getAttribute('data-price');
            var total = price * kilograms;
            document.getElementById('total').value = isNaN(total) ? 'Total' : total.toFixed(2) + ' MXN';
        }

        function toggleOptions(index) {
            var optionsContainer = document.getElementById('optionsContainer');
            if (currentIndex === index) {
                optionsContainer.style.display = 'none';
                currentIndex = null;
            } else {
                optionsContainer.innerHTML = `
                    <button onclick="editItem(${index})">Editar</button>
                    <button onclick="deleteItem(${index})">Eliminar</button>
                `;
                optionsContainer.style.display = 'block';
                optionsContainer.style.position = 'absolute';
                var row = document.querySelector(`tr[data-index="${index}"]`);
                var rect = row.getBoundingClientRect();
                optionsContainer.style.top = rect.bottom + 'px';
                optionsContainer.style.left = rect.left + 'px';
                currentIndex = index;
            }
        }

        function editItem(index) {
            var item = items[index];
            var newKilograms = prompt('Ingrese la nueva cantidad:', item.kilograms);
            if (newKilograms !== null && !isNaN(newKilograms) && newKilograms > 0) {
                items[index].kilograms = parseFloat(newKilograms);
                items[index].total = items[index].kilograms * parseFloat(document.querySelector(`#serviceType option[value="${items[index].serviceType}"]`).getAttribute('data-price'));
                updateItemsTable();
            } else {
                alert('Cantidad inválida.');
            }
        }

        function deleteItem(index) {
            items.splice(index, 1);
            updateItemsTable();
            document.getElementById('optionsContainer').style.display = 'none';
            currentIndex = null;
        }

        function toggleAdvanceInput() {
            var advanceOption = document.getElementById('advanceOption').value;
            var advanceAmount = document.getElementById('advanceAmount');
            advanceAmount.style.display = advanceOption === 'anticipo' ? 'block' : 'none';
        }

        function validateAdvanceAmount(input) {
            var value = input.value;
            if (isNaN(value) || value < 0) {
                input.value = '';
            }
        }

        function setDefaultDeliveryDate() {
            var today = new Date();
            var tomorrow = new Date(today);
            tomorrow.setDate(today.getDate() + 1);
            document.getElementById('deliveryDate').value = tomorrow.toISOString().split('T')[0];
        }


        function printTicket() {
            var name = document.getElementById('name').value;
            var phone = document.getElementById('phone').value;
            var deliveryDate = document.getElementById('deliveryDate').value;
            var advanceOption = document.getElementById('advanceOption').value;
            var advanceAmount = parseFloat(document.getElementById('advanceAmount').value) || 0;

            if (!name || !phone || !deliveryDate) {
                alert('Por favor, complete todos los campos requeridos.');
                return;
            }

            var totalSum = items.reduce((sum, item) => sum + item.total, 0);

            if (advanceOption === 'anticipo' && advanceAmount > totalSum) {
                alert('El anticipo no puede ser mayor al total a pagar.');
                return;
            }

            var ventaData = {
                name: name,
                phone: phone,
                deliveryDate: deliveryDate,
                advanceOption: advanceOption,
                advanceAmount: advanceAmount,
                totalSum: totalSum,
                items: items
            };

            fetch('/save-venta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(ventaData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Venta guardada exitosamente') {
                    alert('Venta guardada exitosamente');
                    generateTicket(name, phone, deliveryDate, advanceOption, advanceAmount, totalSum);
                } else {
                    alert('Error al guardar la venta: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al guardar la venta');
            });
        }

        function generateTicket(name, phone, deliveryDate, advanceOption, advanceAmount, totalSum) {
            var now = new Date(); // Obtiene la fecha y hora actual de la computadora del usuario
            var dateTimeString = now.toLocaleString(); // Convierte la fecha y hora a un formato legible

            var ticketContent = function(type) {
                return `
                    <div style="font-size: 14px; width: 57.5mm; text-align: center; margin: 0 auto;">
                        <h2 style="text-align: center;">Lavandería S.O.S</h2>
                        <h3 style="text-align: center;">${type}</h3>
                        <p style="text-align: left;"><strong>Nombre:</strong> ${name}</p>
                        <p style="text-align: left;"><strong>Teléfono:</strong> ${phone}</p>
                        <p style="text-align: left;"><strong>Fecha de emisión:</strong> ${dateTimeString}</p>
                        <p style="text-align: left;"><strong>Fecha de entrega:</strong> ${deliveryDate}</p>
                        <hr>
                        ${items.map(item => `
                            <p style="text-align: left;">-----${item.serviceType}: ${(item.total / item.kilograms).toFixed(2)} MXN</p>
                            <p style="text-align: left;">${item.kilograms} ${item.tipo} = ${item.total.toFixed(2)} MXN</p>
                        `).join('')}
                        <hr>
                        ${advanceOption === 'ninguno' ? `
                            <p style="text-align: left;"><strong>Total a pagar:</strong> ${totalSum.toFixed(2)} MXN</p>
                        ` : `
                            <p style="text-align: left;"><strong>Total:</strong> ${totalSum.toFixed(2)} MXN</p>
                        `}
                        ${advanceOption === 'anticipo' ? `
                            <p style="text-align: left;"><strong>Anticipo:</strong> ${advanceAmount.toFixed(2)} MXN</p>
                            <p style="text-align: left;"><strong>Restante por pagar:</strong> ${(totalSum - advanceAmount).toFixed(2)} MXN</p>
                        ` : ''}
                        ${advanceOption === 'pagado' ? `
                            <p style="text-align: left;"><strong>PAGADO</strong></p>
                        ` : ''}
                        ${type === 'CLIENTE' || type === 'VENDEDOR' ? `
                            <p style="font-size: 12px; text-align: left;">
                                <strong style="display: block; text-align: center;">Consideraciones:</strong><br>
                                A) El objeto del servicio es el lavado, planchado y tintorería de las prendas que arriba se describen, en caso de ser diferente se especificará.<br>
                                B) No nos hacemos responsables por prendas o artículos después de 30 días. Después de ese periodo tendrá un costo diario de 10 % del total de la nota por concepto de almacenamiento.<br>
                                C) No nos hacemos responsables por objetos olvidados dentro de las prendas.<br>
                                D) La garantía se limita al cumplimiento del servicio solicitado y en base al monto de la presente nota de remisión.
                            </p>
                            <p style="font-size: 12px; text-align: center;">
                                LAVANDERÍA S.O.S<br>MAR DE NORUEGA #9 COL. LAS HADAS, QUERÉTARO, QRO. TEL: 4421043568<br>
                                HORARIO: LUNES A VIERNES DE 8:30 AM A 5:00 PM Y SÁBADO DE 9:00 AM A 2:00 PM.
                            </p>
                        ` : ''}
                    </div>
                `;
            };

            var printWindow = window.open('', '', 'width=800,height=600');
            printWindow.document.write('<html><head><style>body { margin: 0; }</style></head><body>');
            printWindow.document.write(ticketContent('CLIENTE'));
            printWindow.document.write('<div style="page-break-before: always;"></div>');
            printWindow.document.write(ticketContent('VENDEDOR'));
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();

            // Clear items and reset form after printing
            items = [];
            updateItemsTable();
            setDefaultDeliveryDate();

            // Refresh the page after printing
            window.location.reload();
        }


    </script>
</body>
</html>
