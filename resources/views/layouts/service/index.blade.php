@extends('layouts.master.master')
@section('content')
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card custom-card transcation-crypto">
            <div class="card-header border-bottom-0">
                <div class="main-content-label">لیست سرویس ها</div>
            </div>
            <div class="row mb-3">
                <div class="col-sm-4">
                    <input type="text" id="searchTitle" placeholder="عنوان را جستجو کنید" class="form-control">
                </div>
                <div class="col-sm-4">
                    <select id="selectedStatus" class="form-control">
                        <option value="">Show All</option>
                        <option value="on">فعال</option>
                        <option value="off">غیر فعال </option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-1">ردیف</th>
                                <th>عنوان</th>
                                <th>وضعیت</th>
                                <th>توضیحات</th>
                                <th>عکس</th>
                                <th>مشخصات</th>
                                <th>ویژگی ها</th>
                                <th>ویرایش / حذف</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($model as $m)
                                <tr class="border-bottom" id="row-{{ $m->id }}">
                                    <td>
                                        <span class="crypto-icon bg-primary-transparent ml-3 my-auto">
                                            <i class="fe fe-arrow-down-left text-primary"></i>
                                        </span>
                                    </td>
                                    <td class="font-weight-bold title-column">{{ $m->title }}</td>
                                    <td>{{ $m->status }}</td>
                                    <td>{!! $m->description !!}</td>
                                    <td>
                                        <img src="{{ asset('/photos/service/' . $m->pic) }}" alt="pic of the service"
                                            style="width: 60px; height: auto;">
                                    </td>
                                    <td>
                                        <div class="container mt-3">
                                            <table class="table table-bordered table-striped specifications-table data-tbl">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th>Property</th>
                                                        <th>Answer</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (json_decode($m->specifications) as $item)
                                                        <tr>
                                                            <td>{{ $item->property }}</td>
                                                            <td>
                                                                @foreach ($item->answer as $answer)
                                                                    {{ $answer }}@if (!$loop->last)
                                                                        ,
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="container mt-3">
                                            <table class="table table-bordered options-table data-tbl">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Options</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach (json_decode($m->options) as $key => $item)
                                                        <tr>
                                                            <td>
                                                                <table class="table table-sm table-borderless">
                                                                    <tbody>
                                                                        @foreach ($item->{"count$key"} as $option)
                                                                            <tr>
                                                                                <td class="fw-bold">
                                                                                    {{ $option->option->title }}</td>
                                                                                <td>{{ $option->answer }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                            <td class="fw-bold text-center align-middle">{{ $item->price }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="btn-group">
                                            <form action="{{ route('service.edit', $m->id) }}" method="get">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                                            </form>
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                data-id="{{ $m->id }}">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            var selectedStatus = $("#selectedStatus").val(); // Get the selected value ('on' or 'off')

            // Function to filter the table based on status and search
            function filterTable() {
                var selectedStatus = $('#selectedStatus').val(); // Get the selected status
                var searchValue = $('#searchTitle').val().toLowerCase(); // Get the current search value

                // Loop through each table row
                $('#example1 tbody tr').each(function() {
                    var row = $(this);
                    var status = row.find('td:nth-child(3)').text()
                        .trim(); // Get the status from the 3rd <td>
                    var title = row.find('.title-column').text().toLowerCase(); // Get the title

                    // Determine if the row matches the selected status and search value
                    var matchesStatus = (selectedStatus === "" || status === selectedStatus);
                    var matchesSearch = (title.indexOf(searchValue) > -1);

                    // Show or hide the row based on status and search criteria
                    if (matchesStatus && matchesSearch) {
                        row.show();
                        // Show nested tables if the row is visible
                        row.find('.specifications-table, .options-table').show();
                    } else {
                        row.hide();
                        // Hide nested tables if the row is hidden
                        row.find('.specifications-table, .options-table').hide();
                    }
                });
            }

            // Call filterTable when the status dropdown changes
            $('#selectedStatus').change(function() {
                filterTable(); // Filter based on status and search
                $('.data-tbl tbody tr').show();
            });

            // Call filterTable when the search input changes
            $('#searchTitle').on('keyup', function() {
                filterTable(); // Filter based on status and search
                $('.data-tbl tbody tr').show();
            });










            // Delete Functionality with Axios
            $('.delete-btn').on('click', function() {
                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this item?')) {
                    axios.post('/api/deleteService/' + id, {
                            data: {
                                "_token": "{{ csrf_token() }}"
                            }
                        })
                        .then(function(response) {
                            if (response.data.success) {
                                $('#row-' + id).remove();
                                alert('Item deleted successfully.');
                            } else {
                                alert('Failed to delete the item.');
                            }
                        })
                        .catch(function(error) {
                            console.error(error);
                            alert('Error occurred while trying to delete the item.');
                        });
                }
            });


        });
    </script>
@endsection
