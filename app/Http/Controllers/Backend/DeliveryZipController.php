<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Imports\dataimport;
use App\Models\Citie;
use App\Models\Country;
use App\Models\DeliveryZip;
use App\Models\Setting;
use App\Models\Shipping;
use App\Models\ShippingCalculation;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use Redirect;

class DeliveryZipController extends Controller
{
    public function index()
    {
        $contries = Country::all();

        return view('delivery_zip.index', compact('contries'));
    }

    public function add()
    {
        $contries = Country::all();
        $add = true;

        return view('delivery_zip.add', compact('contries', 'add'));
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'p_hallmarked' => 'required|in:code,file',
            'country' => 'required_if:p_hallmarked,code|exists:countries,id',
            'state' => [
                'required_if:p_hallmarked,code',
                'nullable',
                'exists:states,id',
                function ($attribute, $value, $fail) use ($request) {
                    $this->dependenLocation($attribute, $value, $fail, $request, 'country');
                },
            ],
            'city' => [
                'required_if:p_hallmarked,code',
                'nullable',
                'exists:cities,id',
                function ($attribute, $value, $fail) use ($request) {
                    $this->dependenLocation($attribute, $value, $fail, $request, 'state');
                },
            ],
            'file' => 'required_if:p_hallmarked,file|nullable|mimes:xlsx,xls',
            'code' => 'required_if:p_hallmarked,code|nullable|numeric',
        ]);
        if ($request->input('p_hallmarked') === 'code') {
            $zip_code = DeliveryZip::where('country',$request->country)->where('state',$request->state)->where('city',$request->city)->where('code',trim($request->code))->first();
            if(!$zip_code)
            {
                $zip_code = new DeliveryZip();
            }
            $zip_code->country = $request->country ?? null;
            $zip_code->state = $request->state ?? null;
            $zip_code->city = $request->city ?? null;
            $zip_code->code = $request->code ?? null;
            $zip_code->save();
        } else {
            $importedData = Excel::toArray([], $request->file('file'));
            $sheetData = $importedData[0];

            $expectedHeaders = ['zipcode' => 'zip_code', 'state' => 'state', 'city' => 'city'];
            
            $filteredData = array_map(function ($row) {
                return [
                    'zipcode' => $row[0],
                    'state' => $row[1],
                    'city' => $row[2],
                ];
            }, $sheetData);
            $invalid_codes = [];
            foreach ($filteredData as $key => $row) {
                if($key == 0)
                {
                    if ($row !== $expectedHeaders) {
                        return redirect()->back()->with('error','Invalid File!');
                    }
                    continue;
                }
                $stateID = null;
                $cityID = null;
                if (isset($row['state']) && $row['state']) {
                    $state = State::where('country_id',$request->country)->where('name',trim($row['state']))->first();
                    if ($state === null) {
                        $invalid_codes[] = $row['zipcode'];
                        continue;
                    }
                    $stateID = $state->id;
                } 
                if (isset($row['city']) && $row['city']) {
                    $city = Citie::where('state_id',$stateID)->where('name',trim($row['city']))->first();
                    if ($city === null) {
                        $invalid_codes[] = $row['zipcode'];
                        continue;
                    }
                    $cityID = $city->id;
                }
                if ($stateID && $cityID && $row['zipcode'] != null) {
                    $zip_code = DeliveryZip::where('country',$request->country)->where('state',$stateID)->where('city',$cityID)->where('code',trim($row['zipcode']))->first();
                    if(!$zip_code)
                    {
                       $zip_code = new DeliveryZip(); 
                    }
                    $zip_code->country = $request->country ?? null;
                    $zip_code->state = $stateID ?? null;
                    $zip_code->city = $cityID ?? null;
                    $zip_code->code = $row['zipcode'] ?? null;
                    $zip_code->save();
                }
            }
            if(isset($invalid_codes) && count($invalid_codes) > 0)
            {
                $invalid_string = implode(',',$invalid_codes);
                return redirect()->route('delivery_zip.index')->with(['success'=> 'Delivery Zip Code Saved Successfully','invalid_zips' => $invalid_string]);
            }
        }
         return redirect()->route('delivery_zip.index')->with('success','Delivery Zip Code Saved Successfully');
    }

    protected function dependenLocation($attribute, $value, $fail, $request, $key)
    {
        $condition = $key === 'state';
        $item = $condition ? Citie::find($value) : State::find($value);
        if ($item && $request->input($key)) {
            if ($item[$condition ? 'state_id' : 'country_id'] != $request->input($key)) {
                $fail("The selected $attribute does not belong to the specified $key.");
            }
        }
    }

    public function save_old(Request $request)
    {
        // dd($request->all());

        $file = $request->file('file');
        if (isset($file) && $file != null && $file != '') {
            if (isset($request->country) && $request->country != '' && isset($request->state) && $request->state != '') {
                $get_all = DeliveryZip::where('country', $request->country)->where('state', $request->state)->where('city', $request->city)->delete();
            }
            $import = new dataimport;
            $importedData = Excel::toArray($import, $file);

            $rowIndex = 0;
            foreach ($importedData[0] as $row) {
                if (array_filter($row, function ($value) {
                    return ! empty($value);
                })) {
                    $zipCode = $row['zip_code'];
                    // print_r($check_zipCode);
                    $check_zipCode = DeliveryZip::where('code', $zipCode)->where('country', $request->country)->where('state', $request->state)->first();

                    if (isset($zipCode) && is_numeric($zipCode)) {

                        // if (isset($check_zipCode) && $check_zipCode != '') {
                        //     $data['country'] = $request->country;
                        //     $data['state'] = $request->state;
                        //     $data['code'] = $zipCode;
                        //     $check_zipCode->update($data);
                        // }else{
                        DeliveryZip::create([
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'code' => $zipCode,
                        ]);
                        // }
                        // return redirect()->route('delivery_zip.index')->with('success', 'Delivery Zip Code added Successfully.');
                    } else {
                        return redirect()->route('delivery_zip.index')->with('error', 'Delivery Zip Code Plz. Check Only Numric.');
                    }

                }
            }

            return redirect()->route('delivery_zip.index')->with('success', 'Delivery Zip Code added Successfully.');
        } elseif (isset($request->code) && $request->code != '' && $request->code != null) {
            $zip_code = new DeliveryZip;
            $zip_code->country = isset($request->country) ? $request->country : null;
            $zip_code->state = isset($request->state) ? $request->state : null;
            $zip_code->city = isset($request->city) ? $request->city : null;
            $zip_code->code = isset($request->code) ? $request->code : null;
            $zip_code->save();
        }

        return redirect()->route('delivery_zip.index')->with('success', 'Delivery Zip Code Saved Successfully');
    }

    public function update(Request $request, $zip)
    {
        $file = $request->file('file');
        if (isset($file) && $file != null && $file != '') {
            if (isset($request->country) && $request->country != '' && isset($request->state) && $request->state != '') {
                $get_all = DeliveryZip::where('country', $request->country)->where('state', $request->state)->where('city', $request->city)->delete();
            }
            $import = new dataimport;
            $importedData = Excel::toArray($import, $file);

            $rowIndex = 0;
            foreach ($importedData[0] as $row) {
                if (array_filter($row, function ($value) {
                    return ! empty($value);
                })) {
                    $zipCode = $row['zip_code'];
                    $check_zipCode = DeliveryZip::where('code', $zipCode)->where('country', $request->country)->where('state', $request->state)->first();

                    if (isset($zipCode) && is_numeric($zipCode)) {
                        DeliveryZip::updateOrCreate([
                            'id' => $zip,
                            'code' => $zipCode,
                        ], [
                            'country' => $request->country,
                            'state' => $request->state,
                            'city' => $request->city,
                            'code' => $zipCode,
                        ]);
                    } else {
                        return redirect()->route('delivery_zip.index')->with('error', 'Delivery Zip Code Plz. Check Only Numric.');
                    }

                }
            }

            return redirect()->route('delivery_zip.state', ['state' => $request->state, 'city' => $request->city])->with('success', 'Delivery Zip Code added Successfully.');
        } elseif (isset($request->code) && $request->code != '' && $request->code != null) {
            $zip_code = empty($zip) ? new DeliveryZip : DeliveryZip::findOrFail($zip);
            $zip_code->country = isset($request->country) ? $request->country : null;
            $zip_code->state = isset($request->state) ? $request->state : null;
            $zip_code->city = isset($request->city) ? $request->city : null;
            $zip_code->code = isset($request->code) ? $request->code : null;
            $zip_code->save();
        }

        return redirect()->route('delivery_zip.state', ['state' => $request->state, 'city' => $request->city])->with('success', 'Delivery Zip Code Saved Successfully');
    }

    public function get_delivery_global(Request $request)
    {
        $countries = Country::all();
        $htmlContent = View::make('delivery_option.delivery_sec', ['countries' => $countries, 'counter' => $request->counter])->render();

        return response()->json(['counter' => $request->counter, 'countries' => $countries, 'html' => isset($htmlContent) ? $htmlContent : '', 'status' => 1]);
    }

    public function list(Request $request)
    {
        $query = DeliveryZip::with(['country', 'get_state', 'get_city']);
        if (isset($request->country) && $request->country != '' && $request->country != null && $request->country != 'Select') {
            $query->where('country', $request->country);
        }
        if (isset($request->state) && $request->state != '' && $request->state != null && $request->state != 'Select') {
            $query->where('state', $request->state);
        }
        if (isset($request->city) && $request->city != '' && $request->city != null && $request->city != 'Select') {
            $query->where('city', $request->city);
        }
        $deliveryZip_list = $query->latest()->get();
        $counter = 1;
        $processedCombinations = [];
        $filteredDeliveryZipList = collect();

        $deliveryZip_list->transform(function ($item) use (&$counter, &$processedCombinations, &$filteredDeliveryZipList) {
            $stateID = $item->state;
            $cityID = $item->city;

            $combinationKey = $stateID.'-'.$cityID;

            if (! in_array($combinationKey, $processedCombinations)) {
                $count = DeliveryZip::where('state', $item->state)->where('country', $item->country)->where('city', optional($item->get_city)->id)->count();
                $item['ser_id'] = $counter++;
                $item['state_count'] = (isset($item->get_state->name) ? $item->get_state->name : '-').' ('.($count ?? 0).')';
                $item['city'] = isset($item->get_city->name) ? $item->get_city->name : '-';
                $item['viewcode'] = '<a href="'.route('delivery_zip.state', ['state' => $stateID, 'city' => $item->get_city->id]).'" class="tags_delete table-btn table-btn1" title="Click Here To View Zipcode" style="text-decoration: underline;color: #000;"><i class="fa fa-eye" style="font-size:16px;"></i> View Zipcodes</a>';
                $item['action'] = '<a href="'.route('delivery_zip.edit', ['country' => $item->country, 'state' => $stateID, 'city' => $item->get_city->id]).'" class="table-btn table-btn1 mx-2 edit" title="Click Here To Edit Zipcode"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a><a href="javascript:;" data-href="'.route('delivery_zip.delete.state', ['country' => $item->country, 'state' => $stateID, 'city' => $item->get_city->id]).'" class="tags_delete table-btn table-btn1 delete" title="Click Here To Delete Zipcode"><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';
                $processedCombinations[] = $combinationKey;
            } else {
                $item['ser_id'] = '';
                $item['city'] = '';
                unset($stateID, $cityID);
            }

            if ($item['ser_id'] !== '') {
                $filteredDeliveryZipList->push($item);
            }

            return $item;
        });

        return response()->json(['data' => $filteredDeliveryZipList]);
    }

    public function list_by_state($sid, $cid)
    {
        $state = State::where('id', $sid)->first();
        $city = Citie::where('id', $cid)->first();

        return view('delivery_zip.stateindex', compact('state', 'city'));
    }

    public function state_list(Request $request)
    {
        $deliveryZip_list = DeliveryZip::with(['country', 'get_state', 'get_city'])->where('state', $request->state_id)->where('city', $request->city_id)->latest()->get();
        $counter = 1;
        $deliveryZip_list->transform(function ($item) use (&$counter, $request) {
            $item['ser_id'] = $counter++;

            $item['action'] = '<a href="'.route('delivery_zip.state.edit', ['country' => $item->country, 'state' => $request->state_id, 'city' => $item->get_city->id, 'zip' => $item->id]).'" class="table-btn table-btn1 mx-2 edit" title="Click Here To Edit Zipcode"><img src="'.asset('images/dashbord/create.png').'" class="image-fuild" alt="user-img"></a><a href="javascript:;" data-href="'.route('delivery_zip.delete', $item['id']).'" data-title="testrete" data-original-title="Delete Tags" class="tags_delete table-btn table-btn1 delete" title="Click Here To Delete Zip Code" ><img src="'.asset('images/dashbord/delete.png').'" class="image-fuild" alt="user-img"></a>';

            return $item;
        });

        return response()->json(['data' => $deliveryZip_list]);
    }

    public function edit($country, $state, $city)
    {
        $contries = Country::all();
        $edit = true;

        return view('delivery_zip.add', compact('contries', 'country', 'state', 'city', 'edit'));
    }

    public function editZip($country, $state, $city, $zip)
    {
        $contries = Country::all();
        $edit = true;
        $zip_code = DeliveryZip::findOrFail($zip);

        return view('delivery_zip.edit_zip', compact('contries', 'country', 'state', 'city', 'zip', 'zip_code', 'edit'));
    }

    public function check_featured(Request $request)
    {
        $id = $request->id;
        $response['status'] = 0;
        $response['message'] = 'Check Featured canceled';

        if (isset($request->isChecked) && $request->isChecked != 'true') {
            $data['status'] = 0;
            $save = DeliveryZip::where('id', $id)->update($data);
            $response['status'] = 1;
            $response['message'] = 'Disable Successfully';

        } else {
            $data['status'] = 1;
            $save = DeliveryZip::where('id', $id)->update($data);
            $response['status'] = 2;
            $response['message'] = 'Enable Successfully';

        }

        return response()->json($response);
    }

    public function delete($id)
    {
        if ($id != '') {
            $record = DeliveryZip::find($id);

            $record->delete();

            return redirect()->route('delivery_zip.index')
                ->withSuccess('Delivery Zip Code Delete Successfully.');

        }
    }

    public function delete_by_state($country, $state, $city)
    {
        // dd([$country,$state]);
        $data = DeliveryZip::where('country', $country)->where('state', $state)->where('city', $city)->delete();
        if (isset($data)) {
            return redirect()->route('delivery_zip.index')->with('error', 'Delivery Zip Code deleted Successfully!');
        } else {
            return redirect()->route('delivery_zip.index')->with('error', 'Something Went Wrong!');
        }
    }

    public function delivery_option()
    {
        $countries = Country::all();
        $product = Setting::first();
        $data = Shipping::get();

        return view('delivery_option.add', compact('countries', 'product', 'data'));
    }

    public function delivery_option_save(Request $request)
    {
        

        if (isset($request->p_deliver_contry) && $request->p_deliver_contry != null) {
            // Delete non Found shipping data
            $old_shipping_data = Shipping::pluck('id')->toArray();
            if($request->input('each_shipping_id')){
                $flattenedEachShippingId = array_merge(...$request->input('each_shipping_id'));
                if (isset($flattenedEachShippingId) && $flattenedEachShippingId != null) {
                    $missingIds = array_diff($old_shipping_data, $flattenedEachShippingId);
                }
            }
            if (isset($missingIds) && count($missingIds) > 0) {
                $delete_shipping = Shipping::whereIn('id', $missingIds)->delete();
                $delete_shipping_calculation = ShippingCalculation::whereIn('shipping_id', $missingIds)->delete();
            }

            foreach ($request->p_deliver_contry as $key => $country) {
                if (isset($request->each_shipping_id[$key][0]) && $request->each_shipping_id[$key][0] != '' && $request->each_shipping_id[$key][0] != null) {
                    $shipping = Shipping::findOrfail($request->each_shipping_id[$key][0]);
                } else {
                    $shipping = new Shipping;
                }
                $shipping->country = isset($country[0]) ? $country[0] : null;
                $shipping->state = isset($request->p_deliver_state[$key]) ? implode(',', $request->p_deliver_state[$key]) : null;
                $shipping->city = isset($request->p_deliver_city[$key]) ? implode(',', $request->p_deliver_city[$key]) : null;
                $shipping->code = isset($request->p_deliver_code[$key]) ? implode(',', $request->p_deliver_code[$key]) : null;
                $shipping->p_time = isset($request->p_deliver_duration[$key][0]) ? $request->p_deliver_duration[$key][0] : null;
                // dd($shipping);
                $shipping->save();
                $shipping_id = $shipping->id;
                if (isset($request->{'calculation_id_'.$key}[0]) && $request->{'calculation_id_'.$key}[0] != '' && $request->{'calculation_id_'.$key}[0] != null) {
                    $shipping_calculation = ShippingCalculation::findOrfail($request->{'calculation_id_'.$key}[0]);
                } else {
                    $shipping_calculation = new ShippingCalculation;
                }

                $json_data = [];
                // dd($request->{"shipping_type_".$key}[0]);
                if (isset($request->{'shipping_type_'.$key}[0]) && $request->{'shipping_type_'.$key}[0] != null && $request->{'shipping_type_'.$key}[0] == 'on_price') {
                    if (isset($request->{'price_hidden_'.$key}) && $request->{'price_hidden_'.$key} != null) {
                        foreach ($request->{'price_hidden_'.$key} as $index => $val) { // Here's the correction
                            $json_data[] = [
                                'from' => isset($request->{'price_from_amount_'.$key}[$index]) ? $request->{'price_from_amount_'.$key}[$index] : null,
                                'to' => isset($request->{'price_to_amount_'.$key}[$index]) ? $request->{'price_to_amount_'.$key}[$index] : null,
                                'shipping_amount' => isset($request->{'price_shipping_charge_'.$key}[$index]) ? $request->{'price_shipping_charge_'.$key}[$index] : null,
                            ];
                        }
                        $json = json_encode($json_data);
                    }
                }
                if (isset($request->{'shipping_type_'.$key}[0]) && $request->{'shipping_type_'.$key}[0] != null && $request->{'shipping_type_'.$key}[0] == 'on_weight') {
                    if (isset($request->{'weight_hidden_'.$key}) && $request->{'weight_hidden_'.$key} != null) {
                        foreach ($request->{'weight_hidden_'.$key} as $index => $val) {
                            $json_data[] = [
                                'from' => isset($request->{'weight_from_amount_'.$key}[$index]) ? $request->{'weight_from_amount_'.$key}[$index] : null,
                                'to' => isset($request->{'weight_to_amount_'.$key}[$index]) ? $request->{'weight_to_amount_'.$key}[$index] : null,
                                'shipping_amount' => isset($request->{'weight_shipping_charge_'.$key}[$index]) ? $request->{'weight_shipping_charge_'.$key}[$index] : null,
                            ];
                        }
                        $json = json_encode($json_data);
                    }
                }
                if (isset($request->{'shipping_type_'.$key}[0]) && $request->{'shipping_type_'.$key}[0] != null && $request->{'shipping_type_'.$key}[0] == 'on_weight') {
                    $json = null;
                    $shipping_calculation->above_amount = null;
                    $shipping_calculation->above_amount_shipping_charge = null;
                    $shipping_calculation->above_weight = null;
                    $shipping_calculation->above_weight_shipping_charge = null;
                }
                $shipping_calculation->shipping_id = isset($shipping_id) ? $shipping_id : null;
                $shipping_calculation->fix_charge = isset($request->{'fixed_shipping_charge_'.$key}[0]) ? $request->{'fixed_shipping_charge_'.$key}[0] : null;
                $shipping_calculation->type = isset($request->{'shipping_type_'.$key}[0]) ? $request->{'shipping_type_'.$key}[0] : null;
                $shipping_calculation->data = isset($json) ? $json : null;
                $shipping_calculation->above_amount = isset($request->{'price_above_amount_'.$key}[0]) ? $request->{'price_above_amount_'.$key}[0] : null;
                $shipping_calculation->above_amount_shipping_charge = isset($request->{'price_above_shipping_charge_'.$key}[0]) ? $request->{'price_above_shipping_charge_'.$key}[0] : null;
                $shipping_calculation->above_weight = isset($request->{'weight_above_amount_'.$key}[0]) ? $request->{'weight_above_amount_'.$key}[0] : null;
                $shipping_calculation->above_weight_shipping_charge = isset($request->{'weight_above_shipping_charge_'.$key}[0]) ? $request->{'weight_above_shipping_charge_'.$key}[0] : null;
                $shipping_calculation->save();
            }
        }

        return redirect()->route('delivery_option.index')->with('success', 'Shipping Data Saved Successfully!');
    }
}
