<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RentController extends Controller
{
    public function index(Request $request)
    {
        $data = Rent::with('apartment')
        ->select('rents.*', 'sums.sum')
        ->join(DB::raw('(SELECT apartment_id, SUM(amount) as sum FROM rents GROUP BY apartment_id) as sums'), 'rents.apartment_id', '=', 'sums.apartment_id')
        ->paginate($request->get('per_page', 50));

    return response()->json( $data, 200);

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'apartment_id' => 'required|exists:apartments,id',
            'amount' => 'required',
            'description' => 'nullable',

        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }
        $rents = Rent::create([
            'description' =>$request->description ,
            'amount' =>$request-> amount,
            'apartment_id' => $request->apartment_id,
        ]);

        return response()->json($rents, 200);
    }

    public function show($id)
    {
        $rents = Rent::findOrFail($id);
        return response()->json($rents , 200);
    }

    public function update(Request $request, $id)
    {
        $rents = Rent::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'apartment_id' => 'required|exists:apartments,id',
            'amount' => 'required',
            'description' => 'nullable',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }


        $rents->update([
            'description' =>$request->description ,
            'amount' =>$request->amount,
            'apartment_id' => $request->apartment_id,
        ]);

        return response()->json($rents, 200);
    }

    public function destroy($id)
    {
        try {
            $rents = Rent::findOrFail($id);
            $rents->delete();

            return response()->json(['message' => 'تمت عملية الحذف بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الحذف '], 400);
        }
    }

}

