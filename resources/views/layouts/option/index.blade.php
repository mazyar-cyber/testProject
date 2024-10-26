@extends('layouts.master.master')
@section('content')
    <div class="col-md-12 col-lg-12 col-xl-12">
        <div class="card custom-card transcation-crypto">
            <div class="card-header border-bottom-0">
                <div class="main-content-label">لیست آبشن ها</div>
            </div>
            <div class="row">
                <div class="col-sm-4 ">
                    <input type="text" id="searchTitle" placeholder="عنوان را جستجو کنید" class="form-control">
                </div>
                <div class="col-sm-2">
                    <input type="button" class="btn btn-primary" value="Go">
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="example1">
                        <thead>
                            <tr>
                                <th class="wd-1">ردیف</th>
                                <th>عنوان </th>
                                <th>نوع</th>
                                <th>ویزگی ها</th>
                                <th>ویرایش</th>
                                <th>حذف</th>
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
                                    <td>{{ $m->type }}</td>
                                    <td>
                                        {{ $m->options }}
                                    </td>
                                    <td class="d-flex my-auto">
                                        <form action="{{ route('option.edit', $m->id) }}" method="get">
                                            @csrf
                                            <input type="submit" class="btn btn-warning" value="Edit">
                                        </form>
                                    </td>
                                    <td class="font-weight-semibold">
                                        <input type="button" class="btn btn-danger" value="Delete"
                                            onclick="deleteOption({{ $m->id }})">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Row End -->
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            // Listen for the 'keyup' event on the search input
            $('#searchTitle').on('keyup', function() {
                // Get the input value and convert it to lowercase
                var searchValue = $(this).val().toLowerCase();

                // Loop through each table row
                $('#example1 tbody tr').filter(function() {
                    // Toggle the row visibility based on whether the title-column matches the search value
                    $(this).toggle($(this).find('.title-column').text().toLowerCase().indexOf(
                        searchValue) > -1);
                });
            });


        });
        // function deleteOption(id) {
        //     alert('this is delete func' + id);
        //     // const axios = require('axios').default;

        //     axios.get('/api/deleteoption/' + id).then(response => console.log(response.data)).catch(error => console.log(
        //         error));
        // }

        function deleteOption(id) {
            // Confirm before deleting
            if (confirm('Are you sure you want to delete this item?')) {
                // Send a delete request using Axios
                axios.get('/api/deleteoption/' + id)
                    .then(response => {
                        console.log(response.data);

                        // If the delete was successful, remove the row from the table
                        if (response.data.success) {
                            // Remove the row based on the unique ID
                            document.getElementById('row-' + id).remove();
                            alert('Item deleted successfully.');
                        } else {
                            alert('Failed to delete the item.');
                        }
                    })
                    .catch(error => {
                        console.log(error);
                        alert('Error occurred while trying to delete the item.');
                    });
            }
        }
    </script>
@endsection
