<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AX-App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4">Listing Data</h2>
        <div class="row">
            <div class="col-md-3">
                <select class="form-select mb-3" id="attribute">
                    <option value="id">Id</option>
                    <option value="title">Title</option>
                    <option value="price">Price</option>
                    <option value="type">Type</option>
                    <option value="portal">Portal</option>
                    <option value="bed">Bed</option>
                    <option value="bath">Bath</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select mb-3" id="operator">
                    <option value="equals">Equal</option>
                    <option value="not_equals">Not Equal</option>
                    <option value="contain">Contain</option>
                    <option value="starts_with">Start With</option>
                    <option value="ends_with">End With</option>
                    <option value="is">Is</option>
                    <option value="not_is">Not Is</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control mb-3" placeholder="Enter Value" id="value">
            </div>
            <div class="col-md-3">
                <button type="button" class="btn btn-primary" id="filterBtn">Filter</button>
            </div>
        </div>
        <div id="filtersContainer" class="mb-3"></div>
        <table id="listingTable" class="table">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Type</th>
                    <th>Bed</th>
                    <th>Bath</th>
                    <th>Portals</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>


    <!-- Include DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            var filters = []; // Array to store filters
            var table = $('#listingTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false, // Disable searching
                "ajax": {
                    "url": "{{ url('/api/listings') }}",
                    "type": "GET",
                    "dataType": "json",
                    "data": function(d) {
                        d.filters = JSON.stringify(filters);
                        d._token = '{{ csrf_token() }}';
                    },
                    "dataSrc": "data" // Specify the data source property in the JSON response
                },
                "columns": [{
                        "data": "id"
                    }, {
                        "data": "title"
                    },
                    {
                        "data": "price"
                    },
                    {
                        "data": "type"
                    },
                    {
                        "data": "bed"
                    },
                    {
                        "data": "bath"
                    },
                    {
                        "data": "portals",
                        "orderable": false
                    }
                ],
                "order": [
                    [0, "asc"]
                ], // Default sorting by the first column (title) in ascending order
                "language": { // Optional: Configure DataTables language settings
                    "paginate": {
                        "previous": "&laquo;",
                        "next": "&raquo;"
                    }
                }
            });

            // Filter button click event
            $('#filterBtn').click(function() {
                // Get current filter values
                var attribute = $('#attribute').val();
                var operator = $('#operator').val();
                var value = $('#value').val();

                // Check if a similar filter already exists
                var isDuplicate = filters.some(function(filter) {
                    return filter.attribute === attribute && filter.operator === operator && filter.value === value;
                });
                if (!isDuplicate) {
                    // Add filter to the filters array
                    filters.push({
                        attribute: attribute,
                        operator: operator,
                        value: value
                    });
                }
                // Call DataTables API method to reload data
                table.ajax.reload();

                // Update filters display
                updateFiltersDisplay();
            });

            // Function to update filters display
            function updateFiltersDisplay() {
                $('#filtersContainer').empty(); // Clear existing filters

                // Iterate over filters array and display each filter with close button
                filters.forEach(function(filter, index) {
                    var filterHtml = '<div class="badge bg-secondary">' + filter.attribute + ': ' + filter.operator + ' ' + filter.value +
                        '<button type="button" class="btn-close" aria-label="Close" data-index="' + index + '"></button> </div>';
                    $('#filtersContainer').append(filterHtml + '&nbsp;'); // Add space between badges
                });

                // Close button click event to remove filter
                $('.btn-close').click(function() {
                    var index = $(this).data('index');
                    filters.splice(index, 1); // Remove filter from array
                    table.ajax.reload(); // Reload data
                    updateFiltersDisplay(); // Update display
                });
            }
        });
    </script>

</body>

</html>