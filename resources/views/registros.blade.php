
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
        .button-container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            width: auto;
            margin-bottom: 20px;
        }
        .nav-button, .details-button, .delete-button, .print-button, .pay-button {
            width: 200px;
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
        .nav-button:hover, .details-button:hover, .delete-button:hover, .print-button:hover, .pay-button:hover {
            background-color: #009688;
            color: #FFF;
        }
        .search-container, .filter-container {
            width: 80%;
            margin-bottom: 20px;
        }
        .search-input, .filter-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        .filter-container {
            display: flex;
            justify-content: space-between;
        }
        .filter-input {
            width: 30%;
        }
        .date-range {
            display: none;
            width: 60%;
            justify-content: space-between;
        }
        .date-range input {
            width: 45%;
        }
        input[type="date"]::-webkit-inner-spin-button,
        input[type="date"]::-webkit-calendar-picker-indicator {
            display: block;
        }
        input[type="date"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 10px;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="button-container">
        <form method="POST" action="{{ route('misservi') }}" style="width: 100%;">
            @csrf
            <button type="submit" class="nav-button" id="recordButton">Gestión de Servicios</button>
        </form>
        <button class="nav-button" onclick="window.location.href='/venta'">Ventas</button>
    </div>

    <h2>Registros de Ventas</h2>
    <div class="search-container">
        <input type="text" id="searchInput" class="search-input" placeholder="Buscar por nombre de cliente...">
    </div>
    <div class="filter-container">
        <select id="dateFilter" class="filter-input">
            <option value="">Todas las ventas</option>
            <option value="day">Ventas del día</option>
            <option value="week">Ventas de la semana</option>
            <option value="month">Ventas del mes</option>
            <option value="year">Ventas del año</option>
            <option value="custom">Personalizado</option>
        </select>
        <div class="date-range" id="dateRange">
            <input type="date" id="startDate" class="filter-input" placeholder="Fecha de inicio">
            <input type="date" id="endDate" class="filter-input" placeholder="Fecha de fin">
        </div>
        <select id="statusFilter" class="filter-input">
            <option value="order">En orden de venta</option>
            <option value="paid_first">Pagados primero</option>
            <option value="pending_first">Pendientes primero</option>
        </select>
    </div>
    <table id="salesTable">
        <thead>
            <tr>
                <th>Número de Venta</th>
                <th>Fecha de Venta</th>
                <th>Nombre del Cliente</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="salesTableBody">
            @foreach($ventas as $index => $venta)
            <tr data-status="{{ $venta->status }}" data-index="{{ $index }}" data-date="{{ $venta->fecha_venta }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $venta->fecha_venta }}</td>
                <td>{{ $venta->cliente->nombre }}</td>
                <td>{{ $venta->status }}</td>
                <td>
                    <button class="details-button" onclick="toggleDetails({{ $index }})">Detalles</button>
                    <button class="print-button" onclick="printTicket({{ $venta->id }})">Imprimir Ticket</button>
                    @if($venta->status !== 'Pagado')
                    <button class="pay-button" onclick="payRemaining({{ $venta->id }}, {{ $venta->total - $venta->anticipo }})">Pagar Restante</button>
                    @endif
                    <button class="delete-button" onclick="deleteVenta({{ $venta->id }})">Eliminar</button>
                </td>
            </tr>
            <tr class="details details-{{ $index }}" style="display: none;">
                <td colspan="5">
                    <strong>Nombre:</strong> {{ $venta->cliente->nombre }}<br>
                    <strong>Teléfono:</strong> {{ $venta->cliente->telefono }}<br>
                    <strong>Fecha de Venta:</strong> {{ $venta->fecha_venta }}<br>
                    <strong>Fecha de Entrega:</strong> {{ $venta->fecha_entrega }}<br>
                    <strong>Total:</strong> ${{ number_format($venta->total, 2) }}<br>
                    <strong>Anticipo:</strong> ${{ number_format($venta->anticipo, 2) }}<br>
                    <strong>Servicios:</strong>
                    <ul>
                        @foreach($venta->detalles as $detalle)
                        <li>{{ $detalle->servicio->tipo_servicio }} - {{ $detalle->cantidad }} - ${{ number_format($detalle->precio, 2) }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var salesTable = document.getElementById('salesTable').getElementsByTagName('tbody')[0];
            var sales = Array.from(salesTable.getElementsByTagName('tr'))
                .filter(row => !row.classList.contains('details'))
                .map(row => {
                    var cells = row.getElementsByTagName('td');
                    return {
                        index: row.getAttribute('data-index'),
                        saleDate: row.getAttribute('data-date'),
                        name: cells[2].textContent,
                        status: cells[3].textContent,
                        details: row.nextElementSibling.innerHTML,
                        id: row.querySelector('.delete-button').getAttribute('onclick').match(/\d+/)[0],
                        remaining: parseFloat(cells[4].querySelector('.pay-button') ? cells[4].querySelector('.pay-button').getAttribute('onclick').match(/\d+,\s(\d+\.?\d*)\)/)[1] : 0)
                    };
                });

            function loadSales(filteredSales = sales) {
                salesTable.innerHTML = '';
                filteredSales.forEach((sale, index) => {
                    var row = salesTable.insertRow();
                    row.setAttribute('data-index', sale.index);
                    row.setAttribute('data-date', sale.saleDate);
                    row.setAttribute('data-status', sale.status);

                    row.insertCell(0).innerHTML = parseInt(sale.index) + 1;
                    row.insertCell(1).innerHTML = sale.saleDate;
                    row.insertCell(2).innerHTML = sale.name;
                    row.insertCell(3).innerHTML = sale.status;

                    var actionsCell = row.insertCell(4);
                    var detailsButton = document.createElement('button');
                    detailsButton.innerHTML = 'Detalles';
                    detailsButton.className = 'details-button';
                    detailsButton.onclick = function() { toggleDetails(sale.index); };
                    actionsCell.appendChild(detailsButton);

                    var printButton = document.createElement('button');
                    printButton.innerHTML = 'Imprimir Ticket';
                    printButton.className = 'print-button';
                    printButton.onclick = function() { printTicket(sale.id); };
                    actionsCell.appendChild(printButton);

                    if (sale.status !== 'Pagado') {
                        var payButton = document.createElement('button');
                        payButton.innerHTML = 'Pagar Restante';
                        payButton.className = 'pay-button';
                        payButton.onclick = function() { payRemaining(sale.id, sale.remaining); };
                        actionsCell.appendChild(payButton);
                    }

                    var deleteButton = document.createElement('button');
                    deleteButton.innerHTML = 'Eliminar';
                    deleteButton.className = 'delete-button';
                    deleteButton.onclick = function() { deleteVenta(sale.id); };
                    actionsCell.appendChild(deleteButton);

                    var detailsRow = salesTable.insertRow();
                    detailsRow.className = 'details details-' + sale.index;
                    var detailsCell = detailsRow.insertCell(0);
                    detailsCell.colSpan = 5;
                    detailsCell.innerHTML = sale.details;
                });
            }

            loadSales();

            function toggleDetails(index) {
                var detailsRow = document.querySelector('.details-' + index);
                if (detailsRow) {
                    detailsRow.style.display = detailsRow.style.display === 'table-row' ? 'none' : 'table-row';
                }
            }

            function deleteVenta(id) {
                if (confirm('¿Estás seguro de que deseas eliminar esta venta?')) {
                    fetch(`/venta/delete/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Venta eliminada con éxito');
                            window.location.reload();
                        } else {
                            alert('Error al eliminar la venta');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al eliminar la venta');
                    });
                }
            }

            function payRemaining(id, remaining) {
                var amount = parseFloat(prompt(`Monto a pagar (Restante: $${remaining.toFixed(2)}):`));
                if (!isNaN(amount) && amount > 0 && amount <= remaining) {
                    fetch(`/venta/pay-remaining`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ id: id, amount: amount })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`Pago registrado: $${amount.toFixed(2)}\nRestante: $${(remaining - amount).toFixed(2)}`);
                            window.location.reload();
                        } else {
                            alert('Error al registrar el pago');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al registrar el pago');
                    });
                } else {
                    alert('Monto inválido');
                }
            }

            function printTicket(id) {
                fetch(`/venta/${id}/ticket`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            var venta = data.venta;

                            var ticketContent = function(type) {
                                var anticipo = parseFloat(venta.anticipo);
                                var total = parseFloat(venta.total);
                                var restante = total - anticipo;
                                return `
                                    <div style="font-size: 14px; width: 57.5mm; text-align: center; margin: 0 auto;">
                                        <h2 style="text-align: center;">Lavandería S.O.S</h2>
                                        <h3 style="text-align: center;">${type}</h3>
                                        <p style="text-align: left;"><strong>Nombre:</strong> ${venta.cliente.nombre}</p>
                                        <p style="text-align: left;"><strong>Teléfono:</strong> ${venta.cliente.telefono}</p>
                                        <p style="text-align: left;"><strong>Fecha de emisión:</strong> ${venta.fecha_venta}</p>
                                        <p style="text-align: left;"><strong>Fecha de entrega:</strong> ${venta.fecha_entrega}</p>
                                        <hr>
                                        ${venta.detalles.map(detalle => {
                                            let precio = parseFloat(detalle.precio);
                                            let cantidad = parseFloat(detalle.cantidad);
                                            let precioUnitario = precio / cantidad;
                                            return `
                                                <p style="text-align: left;">-----${detalle.servicio.tipo_servicio}: ${precioUnitario.toFixed(2)} MXN</p>
                                                <p style="text-align: left;">${cantidad} ${detalle.servicio.tipo} = ${precio.toFixed(2)} MXN</p>
                                            `;
                                        }).join('')}
                                        <hr>
                                        <p style="text-align: left;"><strong>Total:</strong> ${total.toFixed(2)} MXN</p>
                                        ${anticipo > 0 ? `
                                            <p style="text-align: left;"><strong>${restante === 0 ? 'Pagado:' : 'Anticipo:'}</strong> ${anticipo.toFixed(2)} MXN</p>
                                            ${restante > 0 ? `<p style="text-align: left;"><strong>Restante por pagar:</strong> ${restante.toFixed(2)} MXN</p>` : `<p style="text-align: left;"><strong>PAGADO</strong></p>`}
                                        ` : ''}
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
                        } else {
                            alert('Error al generar el ticket: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al generar el ticket');
                    });
            }







            document.getElementById('searchInput').addEventListener('input', function() {
                filterRows();
            });

            document.getElementById('dateFilter').addEventListener('change', function() {
                var filter = this.value;
                var dateRange = document.getElementById('dateRange');
                if (filter === 'custom') {
                    dateRange.style.display = 'flex';
                } else {
                    dateRange.style.display = 'none';
                    filterRows();
                }
            });

            document.getElementById('startDate').addEventListener('change', function() {
                filterRows();
            });

            document.getElementById('endDate').addEventListener('change', function() {
                filterRows();
            });

            document.getElementById('statusFilter').addEventListener('change', function() {
                filterRows();
            });

            function sortRows(filteredRows, filter) {
                if (filter === 'paid_first') {
                    filteredRows.sort((a, b) => (a.status === 'Pagado' ? -1 : 1) - (b.status === 'Pagado' ? -1 : 1));
                } else if (filter === 'pending_first') {
                    filteredRows.sort((a, b) => (a.status !== 'Pagado' ? -1 : 1) - (b.status !== 'Pagado' ? -1 : 1));
                } else {
                    filteredRows.sort((a, b) => parseInt(b.index) - parseInt(a.index));
                }
            }

            function filterRows() {
                var searchValue = document.getElementById('searchInput').value.toLowerCase();
                var dateFilter = document.getElementById('dateFilter').value;
                var startDate = document.getElementById('startDate').value;
                var endDate = document.getElementById('endDate').value;
                var statusFilter = document.getElementById('statusFilter').value;
                var rows = sales.filter(sale => {
                    var clientName = sale.name.toLowerCase();
                    var date = sale.saleDate;
                    var matchesSearch = clientName.includes(searchValue);
                    var matchesDate = true;

                    if (dateFilter === 'day') {
                        matchesDate = date === new Date().toISOString().split('T')[0];
                    } else if (dateFilter === 'week') {
                        var now = new Date();
                        var startOfWeek = new Date(now.setDate(now.getDate() - now.getDay() + 1)).toISOString().split('T')[0];
                        var endOfWeek = new Date(now.setDate(now.getDate() - now.getDay() + 7)).toISOString().split('T')[0];
                        matchesDate = date >= startOfWeek && date <= endOfWeek;
                    } else if (dateFilter === 'month') {
                        var currentMonth = new Date().toISOString().split('T')[0].slice(0, 7);
                        matchesDate = date.startsWith(currentMonth);
                    } else if (dateFilter === 'year') {
                        var currentYear = new Date().getFullYear();
                        matchesDate = date.startsWith(currentYear.toString());
                    } else if (dateFilter === 'custom') {
                        matchesDate = date >= startDate && date <= endDate;
                    }

                    return matchesSearch && matchesDate;
                });

                sortRows(rows, statusFilter);

                loadSales(rows);
            }

            // Ordenar por defecto las ventas de la más reciente a la más antigua
            filterRows();
        });
    </script>
</body>
</html>

