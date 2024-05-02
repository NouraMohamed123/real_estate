<?php

namespace App\Http\Controllers\Admin;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;



class ExpenseController extends Controller
{
    public function index(Request $request)
    {

        $data = Expense::with('apartment','category')
        ->select('expenses.*', 'sums.sum')
        ->join(DB::raw('(SELECT apartment_id, SUM(amount) as sum FROM expenses GROUP BY apartment_id) as sums'), 'expenses.apartment_id', '=', 'sums.apartment_id')
        ->paginate($request->get('per_page', 50));

    return response()->json($data, 200);


    }





    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'apartment_id' => 'required|exists:apartments,id',
    //         'amount' => 'required',
    //         'description' => 'nullable',
    //         'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
    //         'end_date' => 'required|date_format:Y-m-d|after:start_date',
    //         'category_id' => 'required|exists:categories,id',
    //     ]);

    //     // if ($validator->fails()) {
    //     //     return response()->json([
    //     //         'message' => $validator->errors(),
    //     //     ], 400);
    //     // }

    //     // Parse and format dates using Carbon
    //     $start_date = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
    //     $end_date = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');

    //     $expenses = Expense::create([
    //         'description' => $request->description,
    //         'amount' => $request->amount,
    //         'apartment_id' => $request->apartment_id,
    //         'start_date' => $start_date,
    //         'end_date' => $end_date,
    //         'category_id' => $request->category_id,
    //     ]);

    //     return response()->json($expenses, 200);
    // }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'apartment_id' => 'required|exists:apartments,id',
            'amount' => 'required',
            'description' => 'nullable',
            'start_date' => 'required|date_format:Y-m-d',

            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }

        // Convert dates to Y-m-d format
        $start_date = date('Y-m-d', strtotime($request->start_date));


        $expenses = Expense::create([
            'description' => $request->description,
            'amount' => $request->amount,
            'apartment_id' => $request->apartment_id,
            'start_date' => $start_date,
          
            'category_id' => $request->category_id,
        ]);

        return response()->json($expenses, 200);
    }


    public function show($id)
   {
    $expenses = Expense::with('category', 'apartment')->findOrFail($id);
    return response()->json($expenses, 200);
   }

    public function update(Request $request, $id)
    {
        $expenses = Expense::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'apartment_id' => 'required|exists:apartments,id',
            'amount' => 'required',
            'description' => 'nullable',
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 400);
        }

        // Convert dates to Y-m-d format
        $start_date = date('Y-m-d', strtotime($request->start_date));



        $expenses->update([
            'description' =>$request->description ,
            'amount' =>$request-> amount,
            'apartment_id' => $request->apartment_id,
            'start_date' => $start_date,
           
            'category_id' => $request->category_id,
        ]);

        return response()->json($expenses, 200);
    }

    public function destroy($id)
    {
        try {
            $expenses = Expense::findOrFail($id);
            $expenses->delete();

            return response()->json(['message' => 'تمت عملية الحذف بنجاح'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ أثناء محاولة الحذف '], 400);
        }
    }

}
