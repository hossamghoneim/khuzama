<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Mix;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\Facades\DataTables;

class MixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @throws
     * @return object
     */
    public function index()
    {
        //
        if(\request()->ajax()){

            $mixes = Mix::query()->withCount(['items']);

            return DataTables::eloquent($mixes)
                ->editColumn('created_at', function ($mix){
                    return $mix->created_at->format('Y - m - d') . ' | ' . $mix->created_at->diffForHumans();
                })

                ->editColumn('attachments', function ($mix){

                    $buttons = "No Attachments";

                    if($mix->attachments->count()){
                        $attachmentUrl = $mix->attachment('attachments')->url;
                        $buttons = "<a target='_blank' href='$attachmentUrl' class='btn btn-sm btn-success '><i class='fa fa-download'></i> Download</a>";
                    }

                    return $buttons;
                })

                ->editColumn('options', function ($mix){

                    $show_link = route('mixes.show',$mix->id);
                    $edit_link = route('mixes.edit',$mix->id);
                    $buttons = '';

                    $buttons .= "<a href='$show_link' class='btn btn-sm btn-primary'><i class='fa fa-eye'></i></a>";
                    $buttons .= " | ";
                    $buttons .= "<a href='$edit_link' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
                    $buttons .= " | ";
                    $buttons .= "<button type='button' data-id='$mix->id' class='btn btn-sm btn-danger delete'><i class='fa fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['options','attachments'])
                ->make(true);
        }

        return view('mixes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $items = Item::query()->pluck('name','id')->prepend('Please Select Item',"");

        return view('mixes.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $this->validate($request,[

            'name' => 'required|min:3|max:255|unique:mixes,name',
            'barcode' => 'nullable|min:3|max:255|unique:mixes,barcode',
            'tag' => 'nullable|min:3|max:255',
            'created_at' => 'nullable|date',

            'item_1' => 'required|exists:items,id',
            'item_2' => 'nullable|exists:items,id',
            'item_3' => 'nullable|exists:items,id',
            'item_4' => 'nullable|exists:items,id',
            'item_5' => 'nullable|exists:items,id',

            'percentage_1' => 'required_unless:item_1,|numeric|between:0.001,100',
            'percentage_2' => 'nullable|required_unless:item_2,|numeric|between:0.001,100',
            'percentage_3' => 'nullable|required_unless:item_3,|numeric|between:0.001,100',
            'percentage_4' => 'nullable|required_unless:item_4,|numeric|between:0.001,100',
            'percentage_5' => 'nullable|required_unless:item_5,|numeric|between:0.001,100',
        ]);

        $items_inputs = [];

        for ($i=1;$i<=5;$i++){

            if($request->input('item_'.$i) != null){

                $items_inputs[$request->input('item_'.$i)] =  ['percentage' => $request->input('percentage_'.$i)];
            }

        }

        $request->merge(['created_at' => $request->input('created_at') ? $request->input('created_at') : Carbon::now() ]);

        $mix = Mix::query()->create($request->all(['name','barcode','tag','created_at']));

        $mix->items()->sync($items_inputs);

        if($request->hasFile('attachments')){
            $mix->attach($request->file('attachments'),[
                'key' => 'attachments',
                'disk'=>'public'
            ]);
        }

        flash('Mix Has been Created!')->success();

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mix  $mix
     * @return \Illuminate\Http\Response
     */
    public function show(Mix $mix)
    {
        //
        $mix->load(['items'=> function($items){
            $items->with(['components']);
        }]);

        $as = [];

        $c =  collect($mix->items)->pluck('components')->toArray();

        foreach ($c as $key => $value){

            //$as[$key]['per']  = $mix->items[$key]->pivot->percentage;

            foreach ($value as $keys => $values){

                //$as[$key][$values['allergen']." (".$values['cas'].")"] = $values['pivot']['concentration'] / 100 * $mix->items[$key]->pivot->percentage;
                $as[$key][$values['allergen']] = $values['pivot']['concentration'] / 100 * $mix->items[$key]->pivot->percentage;
            }
        }

        foreach ($as as $ka => $a) {

            // iterate both arrays
            foreach ($a as $key => $value) {
                // iterate all keys+values
                $test = round($value + ($merged[$key] ?? 0),5);

                $merged[$key] = round($value + ($merged[$key] ?? 0),5) ;   // merge and add
            }
        }

        $more = [];

        foreach ($merged as $key => $value){

            if ($value > 0.001){
                $more[]= $key;
            }
        }

        $com = collect($merged)->toBase();

        return view('mixes.show',compact('mix','com','more'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mix  $mix
     * @return \Illuminate\Http\Response
     */
    public function edit(Mix $mix)
    {
        //
        $items = Item::query()->pluck('name','id')->prepend('Please Select Item',"");

        $mix->load(['items']);

        return view('mixes.edit', compact('mix','items'));
    }

    public function update(Request $request, Mix $mix)
    {


        $this->validate($request,[

            'name' => 'required|min:3|max:255|unique:mixes,name,'.$mix->id,
            'barcode' => 'nullable|min:3|max:255|unique:mixes,barcode,'.$mix->id,
            'tag' => 'nullable|min:3|max:255',
            'created_at' => 'nullable|date',

            'item_1' => 'required|exists:items,id',
            'item_2' => 'nullable|exists:items,id',
            'item_3' => 'nullable|exists:items,id',
            'item_4' => 'nullable|exists:items,id',
            'item_5' => 'nullable|exists:items,id',

            'percentage_1' => 'required_unless:item_1,|numeric|between:0.001,100',
            'percentage_2' => 'nullable|required_unless:item_2,|numeric|between:0.001,100',
            'percentage_3' => 'nullable|required_unless:item_3,|numeric|between:0.001,100',
            'percentage_4' => 'nullable|required_unless:item_4,|numeric|between:0.001,100',
            'percentage_5' => 'nullable|required_unless:item_5,|numeric|between:0.001,100',
        ]);

        $items_inputs = [];

        for ($i=1;$i<=5;$i++){

            if($request->input('item_'.$i) != null){

                $items_inputs[$request->input('item_'.$i)] =  ['percentage' => $request->input('percentage_'.$i)];
            }

        }

        $request->merge(['created_at' => $request->input('created_at') ? $request->input('created_at') : Carbon::now() ]);

        $mix->update($request->all(['name','barcode','tag','created_at']));

        $mix->items()->sync($items_inputs);

        if($request->hasFile('attachments')){

            if($mix->attachment('attachments')){

                $mix->attachment('attachments')->delete();
            }

            $mix->attach($request->file('attachments'),[
                'key' => 'attachments',
                'disk'=>'public'
            ]);
        }

        flash('Mix Has been Updated!')->success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mix  $mix
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mix $mix)
    {
        //
        return response()->json($mix->delete(),200);

    }
}
