@extends('layouts.master.master')

@section('content')
    <div class="row row-sm col-sm-12">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">فرم ویرایش سرویس</h6>
                        <p class="text-muted card-sub-title">از طریق این فرم میتوانید سرویس را ویرایش کنید</p>
                    </div>
                    @if ($errors->has('pic'))
                        <span class="text-danger">{{ $errors->first('pic') }}</span>
                    @endif
                    <div class="row row-sm">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <form method="post" action="{{ route('service.update', $model->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('patch')

                                @if ($errors->has('pic'))
                                    <span class="text-danger">{{ $errors->first('pic') }}</span>
                                @endif

                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="">عنوان</label>
                                        <input class="form-control" name="title" required="required" type="text"
                                            required value="{{ $model->title }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="">وضعیت</label>

                                        <div class="row mg-t-10">
                                            <div class="col-lg-3">
                                                <label class="rdiobox"> <input name="status" type="radio" value="on"
                                                        @if ($model->status == 'on') checked="checked" @endif>
                                                    <span>فعال</span></label>
                                            </div>
                                            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                                <label class="rdiobox"><input name="status" type="radio" value="off"
                                                        @if ($model->status == 'off') checked="checked" @endif>
                                                    <span>غبر فعال</span></label>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="">عکس</label>

                                        <div class="row mg-t-10">
                                            <div class="col-lg-3">
                                                <label><input class="form-control" name="pic" type="file" required>
                                                    <span>
                                                    </span></label>
                                            </div>

                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label class="">توضیحات</label>

                                        <div class="row mg-t-10" style="width: 100%">
                                            <div class="col-lg-12 col-sm-12">
                                                <label>
                                                    <textarea style="width: 100%" name="description" id="summernote" class="form-control" required cols="300"
                                                        rows="200"> {!! $model->description !!} </textarea> <span>
                                                    </span>
                                                </label>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="container mt-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">مشخصات</h5>
                                                <input id="numberofprop" type="hidden" name="numberOfProps"
                                                    value="{{ count(json_decode($model->specifications)) }}">
                                                <div id="input-container">
                                                    <table class="table table-bordered specification-table"
                                                        id="specification-table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">نام مشخصه</th>
                                                                <th scope="col">ویژگی</th>
                                                                <th scope="col" class="text-center">عملیات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="specification-tbody">
                                                            <input type="hidden" name="numberOfFirstSpecification"
                                                                value="{{ count(json_decode($model->specifications)) }}"
                                                                id="numberOfFirstSpecification">
                                                            @foreach (json_decode($model->specifications) as $key => $specification)
                                                                <tr class="specification-tr">
                                                                    <td>
                                                                        <input type="text" class="form-control"
                                                                            name="propertyOf{{ $key }}"
                                                                            placeholder="مدیریت فایل"
                                                                            value="{{ $specification->property ?? '' }}">
                                                                    </td>
                                                                    <td>
                                                                        @foreach ($specification->answer as $propAnswer)
                                                                            <input type="text" class="form-control mb-2"
                                                                                name="propAnswer{{ $key }}[]"
                                                                                placeholder="دارد"
                                                                                value="{{ $propAnswer }}">
                                                                        @endforeach
                                                                    </td>
                                                                    <td class="text-center align-middle">
                                                                        <button type="button"
                                                                            class="btn btn-danger remove-specification">
                                                                            حذف
                                                                        </button>
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <input type="button" value="افزودن مشخصه" id="add-input"
                                                            class="btn btn-primary w-100" />
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input type="button" value="افزودن ویژگی" id="add-single-input"
                                                            class="btn btn-secondary w-100" />
                                                    </div>
                                                </div>
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
                                                            @foreach (json_decode($options) as $option)
                                                                <option value="{{ $option->id }}">{{ $option->title }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input id="addButton" type="button"
                                                            class="btn btn-primary w-100" value="افزودن">
                                                        {{-- Hidden input for number of situations --}}
                                                        <input type="hidden" id="numberofSituation"
                                                            name="numberofSituation"
                                                            value="{{ count(json_decode($model->options)) }}">
                                                    </div>
                                                </div>

                                                <!-- Sub-Card for Additional Options -->
                                                <div class="card mb-3" id="options">
                                                    <input type="hidden"
                                                        value="{{ count(json_decode($model->options)) }}"
                                                        name="countCurrentOption" id="countCurrentOption">




                                                    @foreach (json_decode($model->options) as $key => $situation)
                                                        <div class="card mb-3" id="options-{{ $key }}">
                                                            <div class="card-body">
                                                                <h5 class="card-title">Situation {{ $key + 1 }}</h5>
                                                                <div class="row mb-3">
                                                                    <div class="col-md-4 font-weight-bold">عنوان آبشن</div>
                                                                    <div class="col-md-4 font-weight-bold">Type</div>
                                                                    <div class="col-md-4 font-weight-bold">Selection</div>
                                                                </div>

                                                                @foreach ($situation->{'count' . $key} as $option)
                                                                    <div class="row mb-2 align-items-center">
                                                                        <div class="col-md-4">{{ $option->option->title }}
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            {{ $option->option->type == 'dropDown' ? 'Dropdown' : 'Radio' }}
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            @if ($option->option->type == 'dropDown')
                                                                                <input type="hidden"
                                                                                    name="optionTitleOptionof{{ $key }}[]"
                                                                                    value="{{ $option->option->title }}">
                                                                                <select class="form-select form-control"
                                                                                    name="DropdownOptionofOption{{ $option->option->id }}ofCount{{ $key }}[]">
                                                                                    @foreach (explode(',', $option->option->options) as $dropdownOption)
                                                                                        <option
                                                                                            value="{{ $dropdownOption }}"
                                                                                            {{ $dropdownOption == $option->answer ? 'selected' : '' }}>
                                                                                            {{ $dropdownOption }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            @else
                                                                                <input type="hidden"
                                                                                    name="optionTitleOptionof{{ $key }}[]"
                                                                                    value="{{ $option->option->title }}">
                                                                                @foreach (explode(',', $option->option->options) as $radioOption)
                                                                                    <label class="rdiobox">
                                                                                        <input
                                                                                            name="typeofCounter{{ $key }}ofOption{{ $option->option->id }}[]"
                                                                                            type="radio"
                                                                                            value="{{ $radioOption }}"
                                                                                            {{ $radioOption == $option->answer ? 'checked' : '' }}>
                                                                                        <span>{{ $radioOption }}</span>
                                                                                    </label><br>
                                                                                @endforeach
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                @endforeach

                                                                <div class="row mt-3">
                                                                    <div class="col-md-8 text-right font-weight-bold">
                                                                        Price:</div>
                                                                    <div class="col-md-4">
                                                                        <input type="text"
                                                                            name="price{{ $key }}"
                                                                            class="form-control" placeholder="قیمت"
                                                                            value="{{ $situation->price }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
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
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
            let propCount = $('#numberOfFirstSpecification').val();
            let numberofProperty = $('#numberofprop').val();
            // Add new row when button is clicked
            $('#add-input').on('click', function() {
                console.log("Adding new row...");
                var newRow = `
        <tr>
            <td>
                <input type="text" class="form-control" name="propertyOf` + propCount + `" placeholder="مدیریت فایل">
            </td>
            <td>
                <input type="text" class="form-control mb-2" name="propAnswer` + propCount + `[]" placeholder="دارد">
            </td>
            <td class="text-center align-middle">
                <button type="button" class="btn btn-danger remove-specification">
                    حذف
                </button>
            </td>
        </tr>`;
                $('table tbody').append(newRow);
                propCount++; // Increment to ensure unique names for the next set
                numberofProperty++;
                $('#numberofprop').val(numberofProperty);
            });

            // Add new input field to the existing <td> when #add-single-input is clicked
            $('#add-single-input').on('click', function() {
                //  alert('ok');
                // Create the new input field
                var newInput =
                    `<input type="text" class="form-control mb-2" name="propAnswer${(propCount - 1)}[]" placeholder="دارد">`;

                // Target the last <tr> in the specific table by using its ID
                var lastTr = $('table tbody tr').last();

                // Check if the last row exists
                if (lastTr.length > 0) {
                    // Append the new input to the second <td> of the last <tr>
                    lastTr.find('td').eq(1).append(newInput);
                } else {
                    console.error(
                        "No row with the class 'specificationTr' found in the specification table.");
                }
            });


            // Remove the row when delete button is clicked
            $('#specification-table').on('click', '.remove-specification', function() {
                $(this).closest('tr').remove();
                propCount--;
            });
            // let countAddBtn = 0;
            let countAddBtn = $('#countCurrentOption').val();
            let htmlData = `<div class="card-body"> </div>`;
            // Create a temporary DOM element to manipulate the content
            let tempDiv = document.createElement('div');
            tempDiv.innerHTML = htmlData;
            // Select the `.card-body` div inside `tempDiv`
            let cardBody = tempDiv.querySelector('.card-body');
            // Initialize the counter globally, so it persists between button clicks
            // let countAddBtn = 0;

            // Initialize the counter using the value from the hidden input
            // let countAddBtn = parseInt($('#countCurrentOption').val()) || 0;

            $('#addButton').on('click', function() {
                alert('add btn!');

                // Get selected options
                const selectedOptions = $('#optionsSelect').val();

                // Make sure at least one option is selected
                if (selectedOptions.length === 0) {
                    alert('Please select at least one option.');
                    return;
                }

                console.log(selectedOptions);

                // Send the selected options to the Laravel backend
                axios.post('/api/addOptionToService2/' + countAddBtn, {
                        selectedOptions: selectedOptions
                    })
                    .then(function(response) {
                        // Handle success response
                        console.log('Data sent successfully:', response.data);

                        // Append new content to the `.card-body` or a specific container
                        // Append new content to the `.card-body` div
                        cardBody.innerHTML += response.data;
                        let html =
                            '<div id="option-6" class="card-mb-3"><div class="card-body"></div>' +
                            response.data + '  </div>';
                        console.log('html data:', html);
                        $('#options').append(html);

                        alert('Options added successfully!');
                    })
                    .catch(function(error) {
                        // Handle error response
                        console.error('Error sending data:', error);
                        alert('An error occurred while adding options.');
                    });

                // Increment the counter after the request is sent
                countAddBtn++;
                $('#numberofSituation').val(countAddBtn);
                $('#countCurrentOption').val(countAddBtn);
            });



        });
    </script>
@endsection
