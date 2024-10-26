<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Models\admin\OptionController;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // select all service
        $model = Service::all();
        return view("layouts.service.index", compact("model"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $model = OptionController::all();
        return view("layouts.service.create", compact("model"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {
        // specification validation:
        if ($request->numberOfProps == 0 || $request->numberofSituation == 0) {
            return redirect()->back()->with("error", "شما باید حتما به سرویس خود مشخصه و آبشن اضافه کنید");
        }

        $service = new Service();
        $service->title = $request->title;
        $service->status = $request->status;
        //uplode image::
        $file = $request->file('pic');
        $filename = time() . $file->getClientOriginalName();
        $request->file('pic')->move('photos/service/' . $request->name . '/', $filename);

        $service->description = $request->description;
        $service->pic = $filename;
        // Decode the JSON data into an associative array
        $dataArray = $request->all();


        //this part get the specification of serice by their added property and propAnswer
        // Initialize the specification array
        $specification = [];
        for ($i = 0; $i < $request->numberOfProps; $i++) {
            // Construct property name and answer key dynamically
            $propertyKey = 'propertyOf' . $i;
            $answerKey = 'propAnswer' . $i;

            // Check if the keys exist and add them to the specification array
            if (isset($dataArray[$propertyKey]) && isset($dataArray[$answerKey])) {
                $specification[] = [
                    'property' => $dataArray[$propertyKey],
                    'answer' => $dataArray[$answerKey]
                ];
            }
        }
        // return json_encode( $specification,JSON_UNESCAPED_UNICODE);
        $service->specifications = json_encode($specification, JSON_UNESCAPED_UNICODE);

        // Loop through the number of situation that hav added for service
        $optoinsOfService = [];
        $bigData = [];
        for ($i = 0; $i < $request->numberofSituation; $i++) {
            $optionTitleOptionofKey = "optionTitleOptionof" . $i;
            foreach ($request->$optionTitleOptionofKey as $key => $optionName) {
                $option = OptionController::where("title", $optionName)->first();
                if ($option->type == "dropDown") {
                    $DropdownOptionofOptionofCountKey = "DropdownOptionofOption" . $option->id . "ofCount" . $i;
                    $answer = $request->$DropdownOptionofOptionofCountKey[0];
                    $optoinsOfService[] = ['option' => $option, 'answer' => $answer];
                } else {
                    $typeofCounterofOption = "typeofCounter" . $i . "ofOption" . $option->id;
                    $answer = $request->$typeofCounterofOption[0];
                    $optoinsOfService[] = ['option' => $option, "answer" => $answer];
                }

            }
            $priceKey = "price" . $i;
            $bigData[] = ['count' . $i => $optoinsOfService, 'price' => $request->$priceKey];
            //clearing array for next cycle
            $optoinsOfService = [];
            // $bigData[] = [$optoinsOfService];
        }
        // return $finalData=last($bigData);
        $service->options = json_encode($bigData);
        $service->save();
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Find the service by its ID
        $model = Service::find($id);

        // Decode the JSON options into a PHP array for easy manipulation in the view
        $options = OptionController::all();
        // $s = json_decode($model->specifications);
        // return $s[0]->property;
        // Pass both the model and the options to the edit view
        return view('layouts.service.edit', compact('model', 'options'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceStoreRequest $request, $id)
    {
        $service = Service::find($id);
        $service->title = $request->title;
        $service->status = $request->status;
        //uplode image::
        // return $request->pic;
        $file = $request->file('pic');
        $filename = time() . $file->getClientOriginalName();
        $request->file('pic')->move('photos/service/' . $request->name . '/', $filename);

        $service->description = $request->description;
        $service->pic = $filename;
        // $specification = [];
        // Decode the JSON data into an associative array
        $dataArray = $request->all();


        //this part get the specification of serice by their added property and propAnswer
        // Initialize the specification array
        $specification = [];
        for ($i = 0; $i < $request->numberOfProps; $i++) {
            // Construct property name and answer key dynamically
            $propertyKey = 'propertyOf' . $i;
            $answerKey = 'propAnswer' . $i;
            // return $dataArray[$propertyKey];
            // Check if the keys exist and add them to the specification array
            if (isset($dataArray[$propertyKey]) && isset($dataArray[$answerKey])) {

                $specification[] = [
                    'property' => $dataArray[$propertyKey],
                    'answer' => $dataArray[$answerKey]
                ];
            }
        }
        // return json_encode( $specification,JSON_UNESCAPED_UNICODE);
        $service->specifications = json_encode($specification, JSON_UNESCAPED_UNICODE);
        // return json_encode($specification, JSON_UNESCAPED_UNICODE);
        // Loop through the number of situation that hav added for service
        $optoinsOfService = [];
        $bigData = [];
        for ($i = 0; $i < $request->numberofSituation; $i++) {
            $optionTitleOptionofKey = "optionTitleOptionof" . $i;
            foreach ($request->$optionTitleOptionofKey as $key => $optionName) {
                $option = OptionController::where("title", $optionName)->first();
                if ($option->type == "dropDown") {
                    $DropdownOptionofOptionofCountKey = "DropdownOptionofOption" . $option->id . "ofCount" . $i;
                    $answer = $request->$DropdownOptionofOptionofCountKey[0];
                    $optoinsOfService[] = ['option' => $option, 'answer' => $answer];
                } else {
                    $typeofCounterofOption = "typeofCounter" . $i . "ofOption" . $option->id;
                    $answer = $request->$typeofCounterofOption[0];
                    $optoinsOfService[] = ['option' => $option, "answer" => $answer];
                }

            }
            $priceKey = "price" . $i;
            $bigData[] = ['count' . $i => $optoinsOfService, 'price' => $request->$priceKey];
            //clearing array for next cycle
            $optoinsOfService = [];
            // $bigData[] = [$optoinsOfService];
        }
        // return $finalData=last($bigData);
        $service->options = json_encode($bigData);
        $service->save();
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        //
    }

    public function addOptionToService(Request $request, $counter)
    {
        // select the options for sended ids
        $options = OptionController::whereIn("id", $request->selectedOptions)->get();
        $htmlData = [];

        foreach ($options as $option) {
            $items = explode(',', $option->options);
            $labels = []; // Re-initialize $labels for each option

            if ($option->type == 'radio') {
                foreach ($items as $item) {
                    $labels[] = '
                        <div>
                            <label class="rdiobox">
                                <input required name="typeofCounter' . htmlspecialchars($counter) . 'ofOption' . htmlspecialchars($option->id) . '[]" type="radio" value="' . htmlspecialchars($item) . '">
                                <span>' . htmlspecialchars($item) . '</span>
                            </label>
                        </div>';
                }

                $htmlData[] = '
                    <div class="col-md-4">
                    <input type="hidden" name="optionTitleOptionof' . htmlspecialchars($counter) . '[]" value="' . htmlspecialchars($option->title) . '" />
                        <label class="">' . htmlspecialchars($option->title) . '</label>
                        <div class="mb-2">
                            ' . implode($labels) . '
                        </div>
                    </div>';
            } else {
                foreach ($items as $item) {
                    $labels[] = '<option value="' . htmlspecialchars($item) . '">' . htmlspecialchars($item) . '</option>';
                }

                $htmlData[] = '
                    <div class="col-md-4">
                    <input type="hidden" name="optionTitleOptionof' . htmlspecialchars($counter) . '[]" value="' . htmlspecialchars($option->title) . '" />

                    <label>' . htmlspecialchars($option->title) . '</label>
                        <select required class="form-select form-control" name="DropdownOptionofOption' . htmlspecialchars($option->id) . 'ofCount' . htmlspecialchars($counter) . '[]" aria-label="Default select example">
                            ' . implode($labels) . '
                        </select>
                        <div class="col-md-4">
                    </div>

                        </div>';
            }

        }
        $htmlData[] = '<input required type="text"  name="price' . htmlspecialchars($counter) . '" class="form-control"
        placeholder="قیمت">'
        ;
        return implode('', $htmlData);

        // return $options;


    }
    public function addOptionToService2(Request $request, $counter)
    {
        // select all options for sended ids
        $options = OptionController::whereIn("id", $request->selectedOptions)->get();
        $htmlData = [];

        foreach ($options as $option) {
            $items = explode(',', $option->options);
            $labels = []; // Re-initialize $labels for each option
            // $htmlData[] =
            //     '<h5 class="card-title">Situation ' . htmlspecialchars($counter) . '</h5>
            // <div class="row mb-3">
            //     <div class="col-md-4 font-weight-bold">' . htmlspecialchars($option->title) . '</div>
            //     <div class="col-md-4 font-weight-bold">' . htmlspecialchars($option->type) . '</div>
            //     <div class="col-md-4 font-weight-bold">Selection</div>
            // </div>'
            // ;
            if ($option->type == 'radio') {
                foreach ($items as $item) {
                    $labels[] = ' <label class="rdiobox">
                    <input name="typeofCounter' . htmlspecialchars($counter) . 'ofOption' . htmlspecialchars($option->id) . '[]" type="radio"
                    value="' . htmlspecialchars($item) . '">
                    <span>' . htmlspecialchars($item) . '</span>
                </label><br>';
                }

                $htmlData[] = '

             <div class="col-md-4">
             <input type="hidden" name="optionTitleOptionof' . htmlspecialchars($counter) . '[]" value="' . htmlspecialchars($option->title) . '" />
                 <label class="">' . htmlspecialchars($option->title) . '</label>
                 <div class="mb-2">
                     ' . implode($labels) . '
                 </div>
             </div>';
            } else {
                foreach ($items as $item) {
                    $labels[] = '<option value="' . htmlspecialchars($item) . '">' . htmlspecialchars($item) . '</option>';
                }

                $htmlData[] = '
             <div class="col-md-4">
             <input type="hidden" name="optionTitleOptionof' . htmlspecialchars($counter) . '[]" value="' . htmlspecialchars($option->title) . '" />

             <label>' . htmlspecialchars($option->title) . '</label>
                 <select class="form-select form-control" name="DropdownOptionofOption' . htmlspecialchars($option->id) . 'ofCount' . htmlspecialchars($counter) . '[]" aria-label="Default select example">
                     ' . implode($labels) . '
                 </select>
                 <div class="col-md-4">
             </div>

                 </div>';
            }

        }
        $htmlData[] = ' <div class="row mt-3">
        <div class="col-md-8 text-right font-weight-bold">
            Price:</div>
        <div class="col-md-4">
            <input type="text" name="price' . htmlspecialchars($counter) . '" class="form-control" placeholder="قیمت">
        </div>
    </div>'
        ;

        return implode('', $htmlData);

    }
}
