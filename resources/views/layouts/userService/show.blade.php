<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-image {
            max-width: 100%;
            height: auto;
        }

        .table th,
        .table td {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">{{ $service->title }}</h1>
        <div>
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="close"></button> --}}
                </div>
            @endif
        </div>
        <div class="text-center mb-4">
            <img src="{{ asset('photos/service/' . $service->pic) }}" width="500" alt="Product Image"
                class="product-image">
        </div>

        <h2>انتخاب آبشن</h2>

        <form action="{{ route('product.store') }}" method="post">
            @csrf
            <input type="hidden" name="service_id" value="{{ $service->id }}">
            <input type="hidden" id="maxOptionOfService" name="maxOptionOfService" value="{{ $maxOptionOfService }}">
            <div class="container mt-5">
                <h4 class="mb-4">انتخاب محصول</h4>

                @foreach (json_decode($options) as $option)
                    @if ($option->type == 'dropDown')
                        <div class="form-group">
                            <label for="support">{{ $option->title }}</label>
                            <select class="form-control" name="selectedOp-{{ $option->id }}"
                                id="support-{{ $option->id }}">
                                @foreach (explode(',', $option->options) as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                @endforeach

                @foreach (json_decode($options) as $option)
                    @if ($option->type != 'dropDown')
                        <div class="form-group">
                            <label for="radioSelection">{{ $option->title }}</label><br>
                            <div class="form-check form-check-inline">
                                @foreach (explode(',', $option->options) as $item)
                                    <input class="form-check-input" type="radio"
                                        name="radioOptionof{{ $option->id }}"
                                        id="option-{{ $option->id }}-{{ $loop->index }}"
                                        value="{{ $item }}" required>
                                    <label class="form-check-label"
                                        for="option-{{ $option->id }}-{{ $loop->index }}">{{ $item }}</label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach

                <div class="form-group">
                    <label for="price">قیمت</label>
                    <input name="price" value="" class="form-control-plaintext" id="price" readonly />
                </div>
                <div class="form-group">
                    <input class="btn btn-primary col-sm-12" value="اعمال" id="submitBtn" />
                </div>
            </div>
            <h2>مشخصات</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>نام مشخصه</th>
                        <th>Available Choices</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (json_decode($service->specifications) as $speci)
                        <tr>
                            <td>{{ $speci->property }}</td>
                            <td>
                                @foreach ($speci->answer as $ans)
                                    <label for="">{{ $ans }}</label>,
                                @endforeach

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>

            <div class="text-center mt-4">
                <button class="btn btn-primary">Add to Cart</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#submitBtn').click(function() {
                // Create an object to hold the data
                let formData = {};

                // Loop through the dropdowns to get selected values
                @foreach (json_decode($options) as $option)
                    @if ($option->type == 'dropDown')
                        formData['support-{{ $option->id }}'] = $('#support-{{ $option->id }}').val();
                    @endif
                @endforeach

                // Loop through the radio buttons to get selected values
                @foreach (json_decode($options) as $option)
                    @if ($option->type != 'dropDown')
                        formData['radioOptionof{{ $option->id }}'] = $(
                            'input[name="radioOptionof{{ $option->id }}"]:checked').val();
                    @endif
                @endforeach

                // Add the price value to formData
                formData['price'] = $('#price').val();
                formData['maxOptionOfService']=$('#maxOptionOfService').val();

                console.log(formData);
                // Send the data using Axios
                axios.post('/api/calcPrice/' + {{ $service->id }}, formData)
                    .then(function(response) {
                        console.log(response.data);
                        // $('#price').append(response.data);
                        alert(response.data);
                        $('#price').val(response.data);
                        // Handle success (e.g., show a success message)
                    })
                    .catch(function(error) {
                        console.error(error);
                        // Handle error (e.g., show an error message)
                    });
            });
        });
    </script>

</body>

</html>
