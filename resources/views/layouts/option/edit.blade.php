@extends('layouts.master.master')
@section('content')
    <div class="row row-sm col-sm-12">
        <div class="col-lg-12 col-md-12">
            <div class="card custom-card">
                <div class="card-body">
                    <div>
                        <h6 class="main-content-label mb-1">فرم شبکه</h6>
                        <p class="text-muted card-sub-title">طرح گروهی فرم برای وارد کردن اطلاعات کارت هنگام پرداخت.</p>
                    </div>
                    <div class="row row-sm">
                        <div class="col-md-12 col-lg-12 col-xl-12">
                            <form method="post" action="{{ route('option.update',$model->id) }}">
                                @csrf
                                @method('patch')
                                <div class="form-group">
                                    <div class="form-group">
                                        <label class="">عنوان</label>
                                        <input class="form-control" name="title" required="required" type="text"
                                            value="{{ $model->title }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="">نوع</label>

                                        <div class="row mg-t-10">
                                            <div class="col-lg-3">
                                                <label class="rdiobox"><input name="type" type="radio" value="radio"
                                                        @if ($model->type == 'radio') checked="checked" @endif>
                                                    <span>رادیو
                                                        گروب</span></label>
                                            </div>
                                            <div class="col-lg-3 mg-t-20 mg-lg-t-0">
                                                <label class="rdiobox"><input name="type" type="radio" value="dropDown"
                                                        @if ($model->type == 'dropDown') checked="checked" @endif>
                                                    <span>دراب داون</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row row-sm">
                                            <div class="col-sm-4">
                                                <label class="">مقادیر</label><br>
                                                {{-- <input type="button" class="btn btn-primary" value="+"> --}}
                                                <input type="button" class="btn btn-success" id="addInput"
                                                    value="AddInput" />
                                                <input type="button" class="btn btn-danger" id="removeInput"
                                                    value="Substract" />
                                                <br>


                                                <div id="inputContainer" class="col-sm-12">

                                                    @foreach ($options as $option)
                                                        <div class="input-wrapper">
                                                            <label for="">مقدار</label>
                                                            <input type="text" name="option[]"
                                                                class=" form-control  dynamic-input"
                                                                placeholder="مفدار را اینجا بنویسید"
                                                                value="{{ $option }}">
                                                        </div>
                                                    @endforeach

                                                </div><br>
                                            </div>
                                        </div>
                                        <div class="form-group mg-b-20">
                                            <label class="ckbox">
                                                <input checked="" type="checkbox"><span class="tx-13">من با شرایط و
                                                    ضوابط
                                                    موافقم</span>
                                            </label>
                                        </div>
                                        <button class="btn ripple btn-main-primary btn-block">ارسال</button>
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
            // Add input field
            $('#addInput').click(function() {
                // Call the function to add an empty input field
                addInput('');
            });

            // Remove the last input field
            $('#removeInput').click(function() {
                // Check if there are any inputs to remove
                if ($('#inputContainer .input-wrapper').length > 0) {
                    $('#inputContainer .input-wrapper').last().remove();
                }
            });

            // Function to add new input field
            function addInput(value) {
                let inputHTML = `
            <div class="input-wrapper">
                <label>مقدار</label>
                <input type="text" name="option[]" class="form-control dynamic-input" placeholder="مقدار را اینجا بنویسید" value="${value}">
                <br>
            </div>
        `;
                $('#inputContainer').append(inputHTML);
            }
        });
    </script>
@endsection
