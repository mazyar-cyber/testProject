@extends('layouts.master.master')
@section('content')
    <div class="row row-sm col-sm-12">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">فرم ایجاد سرویس</h6>
                        <p class="text-muted card-sub-title">در این قسمت میتوانید یک سرویس ایجاد کنید</p>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data">
                                @csrf
                                @if ($errors->has('pic'))
                                    <span class="text-danger">{{ $errors->first('pic') }}</span>
                                @endif
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="">عنوان</label>
                                        <input class="form-control" name="title" required="required" type="text">
                                    </div>
                                    <div class="form-group">
                                        <label class="">وضعیت</label>

                                        <div class="row mg-t-10">
                                            <div class="col-lg-3">
                                                <label class="rdiobox"><input name="status" type="radio" value="on" required>
                                                    <span>فعال</span></label>
                                            </div>
                                            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                                <label class="rdiobox"><input name="status" type="radio" value="off">
                                                    <span>غبر فعال</span></label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="">عکس</label>

                                        <div class="row mg-t-10">
                                            <div class="col-lg-3">
                                                <label><input class="form-control" name="pic" type="file"> <span>
                                                    </span></label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="">توضیحات</label>

                                        <div class="row mg-t-10" style="width: 100%">
                                            <div class="col-lg-12 col-sm-12">
                                                <label>
                                                    <textarea required style="width: 100%" name="description" id="summernote" class="form-control" cols="300" rows="200"></textarea> <span>
                                                    </span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container mt-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">مشخصات</h5>
                                                <div id="input-container">
                                                    <!-- Input Group 1 -->
                                                    <!-- Separator -->
                                                    <hr>
                                                    <div class="row mb-3 g-2">
                                                        <input id="numberofprop" type="hidden" name="numberOfProps"
                                                            value="">
                                                        {{-- <div class="col-md-4">
                                                            <input type="text" class="form-control"
                                                                placeholder="مدیریت فایل">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input type="text" class="form-control" placeholder="دارد">
                                                        </div> --}}
                                                    </div>
                                                    <hr>
                                                </div>

                                                <!-- Separator -->
                                                <hr>
                                                <div class="row mb-3">
                                                    <div class="col-md-4">
                                                        <input type="button" id="add-input" value="افزودن مشخصه"
                                                            class="btn btn-primary w-100" />
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input type="button" value="افزودن ویژگی بیشتر" id="add-single-input"
                                                            class="btn btn-secondary w-100" />
                                                    </div>
                                                </div>

                                                <!-- Separator -->
                                                <hr>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="container mt-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">آبشن ها و قیمت خدمات</h5>

                                                <!-- Select Dropdown and Add Button -->
                                                <div class="row mb-3">
                                                    <div class="col-md-8">
                                                        <select class="form-select form-control" id="optionsSelect"
                                                            name="selectedOptions" aria-label="Default select example"
                                                            multiple>
                                                            @foreach ($model as $m)
                                                                <option value="{{ $m->id }}">{{ $m->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input id="addButton" type="button" class="btn btn-primary w-100"
                                                            value="افزودن">
                                                        {{-- this tag is for number of situation or addedBtn --}}
                                                        <input type="hidden" id="numberofSituation"
                                                            name="numberofSituation" value="">
                                                    </div>
                                                </div>

                                                <!-- Sub-Card for Additional Options -->
                                                <div class="card mb-3">
                                                    <div class="card-body" id="options">
                                                        <div class="row mb-3 card">


                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <button class="btn btn-primary col-sm-12">ذخیره </button>
                                    </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
            // Add new input group with both fields
            let propCount = 0;
            let propAnswer = propCount;
            let numberofProperty = 0;
            $('#add-input').click(function() {
                const newInputGroup = `
                <hr>
                    <div class="row mb-3 g-2">
                        <div class="col-md-4">
                            <input type="text" name="propertyOf` + propCount + `" class="form-control" placeholder="مدیریت فایل">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="propAnswer` + propCount + `[]" class="form-control" placeholder="دارد">
                        </div>
                        <hr>
                    </div>`;

                $('#input-container').append(newInputGroup);
                numberofProperty++;
                $('#numberofprop').val(numberofProperty);
                propAnswer = propCount;
                propCount++;

                console.log(propCount);
            });

            // Add a single input field with "دارد" placeholder
            $('#add-single-input').click(function() {
                const newInput = `
                    <div class="row mb-3 g-2">
                        <div class="col-md-4 offset-md-4">
                            <input type="text" name="propAnswer` + propAnswer + `[]" class="form-control" placeholder="دارد">
                        </div>
                    </div>`;

                $('#input-container').append(newInput);
            });
            let countAddBtn = 0;
            $('#addButton').on('click', function() {
                alert(countAddBtn);
                // Get selected options
                const selectedOptions = $('#optionsSelect').val();
                let counter = 0; // Initialize the counter on the client side
                // Make sure at least one option is selected
                if (selectedOptions.length === 0) {
                    alert('Please select at least one option.');
                    return;
                }
                console.log(selectedOptions);
                // Send the selected options to the Laravel backend
                axios.post('/api/addOptionToService/' + countAddBtn, {
                        selectedOptions: selectedOptions
                    })
                    .then(function(response) {
                        // Handle success response
                        console.log('Data sent successfully:', response.data);
                        //we should append html data to a tag to .card-body
                        // Properly append the response data to the #options element
                        $('#options').append($.parseHTML(response.data));
                        alert('Options added successfully!');
                    })
                    .catch(function(error) {
                        // Handle error response
                        console.error('Error sending data:', error);
                        alert('An error occurred while adding options.');
                    });
                countAddBtn = countAddBtn + 1;
                $('#numberofSituation').val(countAddBtn);

            });

        });
    </script>
@endsection
