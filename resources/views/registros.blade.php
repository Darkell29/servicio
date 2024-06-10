<!DOCTYPE html>
<html>
<head>
    <title>Registros de Ventas</title>
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
        .details {
            display: none;
        }
        .back-button, .details-button, .delete-button {
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
        .back-button:hover, .details-button:hover, .delete-button:hover {
            background-color: #009688;
            color: #FFF;
        }
    </style>
</head>
<body>
    <button class="back-button" onclick="window.location.href='index.html'">Cerrar Sesión</button>
    <h2>Registros de Ventas</h2>
    <table id="salesTable">
        <thead>
            <tr>
                <th>Número de Venta</th>
                <th>Fecha de Venta</th>
                <th>Nombre del Cliente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var urlParams = new URLSearchParams(window.location.search);
            var user = urlParams.get('user');
            var sales = JSON.parse(localStorage.getItem('sales')) || [];
            var salesTable = document.getElementById('salesTable').getElementsByTagName('tbody')[0];
            var today = new Date().toISOString().split('T')[0];

            sales.forEach((sale, index) => {
                if (user === 'vendedor' && sale.saleDate !== today) {
                    return; // Skip this sale if the user is a vendor and the sale date is not today
                }

                var row = salesTable.insertRow();
                row.insertCell(0).innerHTML = index + 1;
                row.insertCell(1).innerHTML = sale.saleDate;
                row.insertCell(2).innerHTML = sale.name;

                var actionsCell = row.insertCell(3);
                var detailsButton = document.createElement('button');
                detailsButton.innerHTML = 'Detalles';
                detailsButton.className = 'details-button';
                detailsButton.onclick = function() { toggleDetails(index); };
                actionsCell.appendChild(detailsButton);

                if (user === 'admin') {
                    var deleteButton = document.createElement('button');
                    deleteButton.innerHTML = 'Eliminar';
                    deleteButton.className = 'delete-button';
                    deleteButton.onclick = function() { deleteSale(index); };
                    actionsCell.appendChild(deleteButton);
                }

                var detailsRow = salesTable.insertRow();
                detailsRow.className = 'details details-' + index;
                var detailsCell = detailsRow.insertCell(0);
                detailsCell.colSpan = 4;
                detailsCell.innerHTML = `
                    <strong>Nombre:</strong> ${sale.name}<br>
                    <strong>Teléfono:</strong> ${sale.phone}<br>
                    <strong>Tipo de Servicio:</strong> ${sale.serviceType}<br>
                    <strong>Cantidad:</strong> ${sale.kilograms} ${sale.serviceType === 'ropa por kilo' ? 'kg' : 'piezas'}<br>
                    <strong>Anticipo:</strong> ${sale.advance === 'pagado' ? 'Pagado' : 'Anticipo de ' + sale.advanceAmount}<br>
                    <strong>Fecha de Entrega:</strong> ${sale.deliveryDate}<br>
                    <strong>Fecha de Venta:</strong> ${sale.saleDate}<br>
                    <strong>Total:</strong> ${sale.total}
                `;
            });
        });

        function toggleDetails(index) {
            var detailsRow = document.querySelector('.details-' + index);
            if (detailsRow) {
                detailsRow.style.display = detailsRow.style.display === 'table-row' ? 'none' : 'table-row';
            }
        }

        function deleteSale(index) {
            var sales = JSON.parse(localStorage.getItem('sales')) || [];
            sales.splice(index, 1);
            localStorage.setItem('sales', JSON.stringify(sales));
            location.reload();
        }
    </script>
</body>
</html>
