<!DOCTYPE html>
<html>
<head>
    <title>Lavandería Gonzalo</title>
    <style>
        body {
            display: grid;
            grid-template-columns: 1fr 2fr 1fr;
            grid-template-rows: 1fr 3fr;
            height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .logo-container {
            grid-column: 1;
            grid-row: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #1A237E;
            color: #FFF;
            padding: 20px;
        }
        .logo-container img {
            width: 300px;
            height: 300px;
        }
        .table-container {
            grid-column: 1;
            grid-row: 2;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #1A237E;
            color: #BDBDBD;
            padding: 20px;
        }
        .table-container table {
            width: 100%;
        }
        .table-container table, th, td {
            border: 1px solid #BDBDBD;
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
            background-color: #1A237E;
            color: #BDBDBD;
            padding: 20px;
        }
        .form-container h2 {
            margin-bottom: 30px;
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
            background-color: #009688;
        }
        .image-container {
            grid-column: 3;
            grid-row: 1 / span 2;
            background-image: url('imagenes/fondo.jpg');
            background-size: cover;
            background-position: center;
        }
        .error {
            color: red;
            font-size: small;
        }
        /* Estilos para la tabla */
        .items-table {
            grid-column: 3;
            grid-row: 1 / span 2;
            display: none; /* La tabla está oculta al principio */
            background-color: #FFE0B2; /* Color de fondo de la tabla */
            color: #212121; /* Color del texto de la tabla */
            overflow-y: auto; /* Hace que la tabla sea desplazable */
            height: 100%; /* Ajusta esto a la altura que prefieras */
        }
        .items-table th {
            background-color: #F57C00; /* Color de fondo de los encabezados de la tabla */
            color: #FFF; /* Color del texto de los encabezados de la tabla */
        }
        .items-table td {
            background-color: #FF9800; /* Color de fondo de las celdas de la tabla */
            color: #757575; /* Color del texto de las celdas de la tabla */
        }
        /* Estilos para el botón de registros para que se parezca al botón de venta */
        .record-button {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #BDBDBD;
            background-color: #1A237E;
            color: #FFF;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s, color 0.3s;
        }
        .record-button:hover {
            background-color: #009688;
            color: #FFF;
        }
    </style>
</head>
<body>
    <div class="logo-container">
        <img src="imagenes/logo.png" alt="Logo">
    </div>
    <div class="table-container">
        <table>
           
        </table>
        <button class="record-button" id="recordButton">Registros</button>
    </div>
    <div class="form-container" id="formContainer">
        <h2>SUPER CLEAN</h2>
        <input type="text" id="name" class="full-input" placeholder="Nombre" oninput="validateName()">
        <span id="nameError" class="error"></span>
        <div style="display: flex; justify-content: space-between; width: 80%;">
            <input type="text" id="phone" class="half-input" placeholder="Teléfono" oninput="validatePhone()">
            <select id="serviceType" class="half-input" onchange="updateServiceType()">
                <option value="ropa por kilo">Ropa por kilo</option>
                <option value="edredon individual">Edredón individual</option>
                <option value="edredon matrimonial">Edredón matrimonial</option>
                <option value="edredon queen size">Edredón queen size</option>
                <option value="edredon king size">Edredón king size</option>
                <option value="colcha">Colcha</option>
                <option value="sabana">Sábana</option>
                <option value="planchado">Planchado</option>
            </select>
        </div>
        <div style="display: flex; justify-content: space-between; width: 80%;">
            <input type="text" id="kilograms" class="half-input" placeholder="Kilogramos">
            <select id="advance" class="half-input" onchange="toggleAdvanceAmount()">
                <option value="anticipo">Anticipo</option>
                <option value="pagado">Pagado</option>
            </select>
            <input type="text" id="advanceAmount" class="half-input" placeholder="Cantidad de anticipo" oninput="validateAdvanceAmount()">
        </div>
        <div style="display: flex; justify-content: space-between; width: 80%;">
            <input type="date" id="deliveryDate" class="half-input" min="2022-01-01">
            <input type="text" id="total" class="half-input" placeholder="Total" value="Total" readonly>
        </div>
        <button onclick="addItem()">Agregar</button>
        <button onclick="printTicket()">Imprimir ticket</button>
    </div>
    <div class="image-container" id="imageContainer"></div>
    <table class="items-table" id="itemsTable">
        <tr>
            <th>Servicio</th>
            <th>Cantidad</th>
            <th>Total</th>
        </tr>
    </table>
    <script>
        var items = [];
        var sales = JSON.parse(localStorage.getItem('sales')) || [];
        var prices = {
            'ropa por kilo': 55,
            'edredon individual': 75,
            'edredon matrimonial': 85,
            'edredon queen size': 100,
            'edredon king size': 110,
            'colcha': 60,
            'sabana': 30,
            'planchado': 10
        };

        document.addEventListener("DOMContentLoaded", function() {
            var urlParams = new URLSearchParams(window.location.search);
            var user = urlParams.get('user');
            document.getElementById('recordButton').onclick = function() {
                window.location.href = 'registros.html?user=' + user;
            };
        });

        function addItem() {
            var serviceType = document.getElementById('serviceType').value;
            var kilograms = document.getElementById('kilograms').value;
            var total = prices[serviceType] * kilograms;

            if (serviceType === '' || kilograms === '') {
                alert('No se permiten valores vacíos');
                return;
            }

            items.push({
                serviceType: serviceType,
                kilograms: kilograms,
                total: total
            });

            updateItemsTable();
            document.getElementById('imageContainer').style.display = 'none'; // Oculta la imagen de fondo
            document.getElementById('itemsTable').style.display = 'block'; // Muestra la tabla
        }

        function updateItemsTable() {
            var table = document.getElementById('itemsTable');
            table.innerHTML = '<tr><th>Servicio</th><th>Cantidad</th><th>Total</th></tr>'; // Reset the table

            var totalSum = 0;
            for (var i = 0; i < items.length; i++) {
                var row = table.insertRow(-1);
                row.insertCell(0).innerHTML = items[i].serviceType;
                row.insertCell(1).innerHTML = items[i].kilograms;
                row.insertCell(2).innerHTML = items[i].total;
                totalSum += items[i].total;
            }
            document.getElementById('total').value = totalSum;
        }

        function updateServiceType() {
            var serviceType = document.getElementById('serviceType').value;
            if (serviceType === 'ropa por kilo' || serviceType === 'planchado') {
                document.getElementById('kilograms').placeholder = 'Kilogramos';
            } else {
                document.getElementById('kilograms').placeholder = 'Piezas';
            }
        }

        function validateName() {
            var name = document.getElementById('name').value;
            if (!/^[a-zA-Z\s]*$/.test(name)) {
                document.getElementById('nameError').textContent = 'Este campo no acepta valores numéricos';
            } else {
                document.getElementById('nameError').textContent = '';
            }
        }

        function validatePhone() {
            var phone = document.getElementById('phone').value;
            if (!/^\d{10}$/.test(phone)) {
                document.getElementById('phoneError').textContent = '*Se necesitan 10 dígitos';
            } else {
                document.getElementById('phoneError').textContent = '';
            }
        }

        function toggleAdvanceAmount() {
            var advance = document.getElementById('advance').value;
            var advanceAmountField = document.getElementById('advanceAmount');
            if (advance === 'pagado') {
                advanceAmountField.value = '';
                advanceAmountField.disabled = true;
            } else {
                advanceAmountField.disabled = false;
            }
        }

        function printTicket() {
            var name = document.getElementById('name').value;
            var phone = document.getElementById('phone').value;
            var deliveryDate = document.getElementById('deliveryDate').value;
            var advance = document.getElementById('advance').value;
            var advanceAmount = document.getElementById('advanceAmount').value || '0';
            var total = document.getElementById('total').value;
            var saleDate = new Date().toISOString().split('T')[0];

            if (name === '' || phone === '' || deliveryDate === '' || total === '') {
                alert('No se permiten valores vacíos');
            } else if (!/^[a-zA-Z\s]*$/.test(name)) {
                alert('Nombre: este campo no acepta valores numéricos');
            } else if (!/^\d{10}$/.test(phone)) {
                alert('Teléfono: se necesitan 10 dígitos');
            } else {
                var ticket = 'Ticket: \n';
                ticket += 'Nombre: ' + name + '\n';
                ticket += 'Teléfono: ' + phone + '\n';
                ticket += 'Fecha de entrega: ' + deliveryDate + '\n';

                for (var i = 0; i < items.length; i++) {
                    ticket += 'Producto: ' + items[i].serviceType + ', Cantidad: ' + items[i].kilograms + ', Total: ' + items[i].total + '\n';
                }

                ticket += 'Total: ' + total + '\n';
                ticket += 'Cantidad de anticipo: ' + (advance === 'pagado' ? 'Pagado' : advanceAmount) + '\n';
                ticket += '----------------------------------\n';
                ticket += 'Restante: ' + (advance === 'pagado' ? '0' : (total - advanceAmount)) + '\n';

                alert(ticket);

                sales.push({
                    name: name,
                    phone: phone,
                    serviceType: items.map(item => item.serviceType).join(', '),
                    kilograms: items.map(item => item.kilograms).join(', '),
                    advance: advance,
                    advanceAmount: advanceAmount,
                    deliveryDate: deliveryDate,
                    saleDate: saleDate,
                    total: total
                });
                localStorage.setItem('sales', JSON.stringify(sales));

                // Limpiar los campos después de imprimir el ticket
                document.getElementById('name').value = '';
                document.getElementById('phone').value = '';
                document.getElementById('serviceType').value = 'ropa por kilo';
                document.getElementById('kilograms').value = '';
                document.getElementById('advance').value = 'anticipo';
                document.getElementById('advanceAmount').value = '';
                document.getElementById('deliveryDate').value = '';
                document.getElementById('total').value = 'Total';
                items = [];
                updateItemsTable();
            }
        }
    </script>
</body>
</html>
