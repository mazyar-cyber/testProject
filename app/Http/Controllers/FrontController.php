<?php

namespace App\Http\Controllers;

use App\Models\admin\OptionController;
use App\Models\Basket;
use App\Models\Service;
use Auth;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // select all basket and user basket
        $basket = Basket::all();
        $userBaskets = Basket::where("user_id", Auth::user()->id)->get();
        return view("layouts.basket.index", compact(["basket", "userBaskets"]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->price;

        //check for existing model first:
        $basket = Basket::where("user_id", Auth::user()->id)->where("service_id", $request->service_id)->get();
        // return count($basket);
        if ($basket->count() != 0) {
            return redirect()->back()->with("error", "You have selected this product before");
        }
        if ($request->price == "no exist") {
            return redirect()->back()->with("error", "there is no price!");

        }
        $model = new Basket();
        $model->user_id = Auth::user()->id;
        $options = OptionController::all();
        $data = [];
        foreach ($options as $option) {
            if ($option->type == 'dropDown') {
                $selectedOp = "selectedOp-$option->id";
                $data[] = ['optionName' => $option->title, 'answer' => $request->$selectedOp];
            } else {
                $radioOptionof = "radioOptionof$option->id";
                $data[] = ['optionName' => $option->title, 'answer' => $request->$radioOptionof];
            }
        }
        $model->options = json_encode($data, JSON_UNESCAPED_UNICODE);
        $model->service_id = $request->service_id;
        $model->price = $request->price;
        $model->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //check for status
        $service = Service::find($id);
        foreach (json_decode($service->options) as $key => $sit) {
            $count = "count$key";
            $numberOfoptions[] = count($sit->$count);
            foreach ($sit->$count as $key => $option) {
                $optionsIds[] = $option->option->id;
            }
        }
        $optionsIds = array_unique($optionsIds);
        $maxOptionOfService = max($numberOfoptions);

        if ($service->status == 'off') {
            return redirect()->back()->with("error", "The status of this service is off!");

        }
        $options = OptionController::whereIn("id", $optionsIds)->get();
        return view("layouts.userService.show", compact(["service", "options", "maxOptionOfService"]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function calcPrice(Request $request, $id)
    {
        //return $request->all();
        // Find the service by ID
        $service = Service::find($id);
        $price = 'no exist';
        // Decode the service options JSON
        $serviceOptions = json_decode($service->options, true); // Assuming options is a JSON column

        // Prepare the input data from the request
        $inputData = $request->all(); // This will contain your provided array

        // Initialize a variable to store the matched price
        $matchedPrice = null;

        // Loop through each service option
        foreach ($serviceOptions as $key => $optionGroup) {
            $count = 'count' . $key;
            $countOfServiceOp = count($optionGroup[$count]);


            $isGroupMatched = true; // Flag to track if the group is matched


            foreach ($optionGroup[$count] as $option) {
                $isMatch = false;
                $opAnswer = $option['answer'];
                $opId = $option['option']['id'];
                $support = "support-$opId";
                $radioOptionof = "radioOptionof$opId";


                if (count($optionGroup[$count]) < ($request->maxOptionOfService)) {
                    $isGroupMatched = false;
                    break;
                } else {

                    if ($option['option']['type'] == 'dropDown') {
                        if ($inputData[$support] != $opAnswer) {
                            $isGroupMatched = false;
                            break; // Exit if one answer doesn't match
                        }
                    } else {
                        if ($inputData[$radioOptionof] != $opAnswer) {
                            $isGroupMatched = false;
                            break; // Exit if one answer doesn't match
                        }
                    }
                }

            }

            // If all options in the group matched, return the price
            if ($isGroupMatched) {
                $price = $optionGroup['price'];
                return $optionGroup['price'];
            }

        }
        return $price;
    }


}
