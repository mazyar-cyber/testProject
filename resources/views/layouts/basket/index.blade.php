<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Basket</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        h1 {
            color: #343a40;
        }

        .total-price {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .btn-checkout {
            background-color: #007bff;
            color: white;
        }

        .btn-checkout:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h1 class="mb-4">Your Shopping Basket</h1>
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>Product</th>
                    <th>Options</th>
                    <th>Price</th>
                    <th>delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($userBaskets as $product)
                    <tr id="row-{{ $product->id }}">
                        <td>{{ $product->service->title }}</td>
                        <td>
                            <table>
                                <thead>
                                    <tr>
                                        @foreach (json_decode($product->options) as $option)
                                            <td>{{ $option->optionName }}</td>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        @foreach (json_decode($product->options) as $option)
                                            <td>{{ $option->answer }}</td>
                                        @endforeach

                                    </tr>
                                </tbody>
                            </table>

                        </td>
                        <td class="product-price">{{ $product->price }}</td>
                        <td>
                            <input type="button" class="btn btn-danger deleteBtn" value="حذف"
                                data-id="{{ $product->id }}">
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between mt-4">
            <h3 class="total-price">Total Price:</h3>
            <h3 class="total-price" id="totalPrice"></h3>
        </div>

        <button class="btn btn-checkout mt-3">Proceed to Checkout</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script>
        $(document).ready(function() {
            // Delete Functionality with Axios
            $('.deleteBtn').on('click', function() {

                var id = $(this).data('id');
                if (confirm('Are you sure you want to delete this item?')) {
                    axios.post('/api/deleteProduct/' + id, {
                            data: {
                                "_token": "{{ csrf_token() }}"
                            }
                        })
                        .then(function(response) {
                            if (response.data.success) {
                                $('#row-' + id).remove();
                                alert('Item deleted successfully.');
                                calculateTotalPrice();
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

            function calculateTotalPrice() {
                let total = 0;

                $('.product-price').each(function() {
                    // Convert the text to a float and add it to the total
                    let priceText = $(this).text().replace(/[^0-9]/g, '').trim();
                    total += parseFloat(priceText) || 0;
                });


                let formattedTotal = total.toLocaleString('en-US', {
                    style: 'currency',
                    currency: 'USD',
                });


                // Update the total price element
                $('#totalPrice').text(formattedTotal);
            }

            // Call the function to calculate and display the total price on page load
            calculateTotalPrice();
        });
    </script>
</body>

</html>
