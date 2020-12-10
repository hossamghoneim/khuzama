<?php

namespace App\Http\Controllers;

use App\Models\Component;
use App\Models\Item;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Yajra\DataTables\Facades\DataTables;

class ItemController extends Controller
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

            $items = Item::query();

            return DataTables::eloquent($items)
                ->editColumn('created_at', function ($item){
                    return $item->created_at->format('Y - m - d') . ' | ' . $item->created_at->diffForHumans();
                })

                ->editColumn('attachments', function ($item){

                    $buttons = "No Attachments";

                    if($item->attachments->count()){
                        $attachmentUrl = $item->attachment('attachments')->url;
                        $buttons = "<a target='_blank' href='$attachmentUrl' class='btn btn-sm btn-success '><i class='fa fa-download'></i> Download</a>";
                    }

                    return $buttons;
                })

                ->editColumn('options', function ($item){

                    $show_link = route('items.show',$item->id);
                    $edit_link = route('items.edit',$item->id);
                    $buttons = '';

                    $buttons .= "<a href='$show_link' class='btn btn-sm btn-primary'><i class='fa fa-eye'></i></a>";
                    $buttons .= " | ";
                    $buttons .= "<a href='$edit_link' class='btn btn-sm btn-success'><i class='fa fa-edit'></i></a>";
                    $buttons .= " | ";
                    $buttons .= "<button type='button' data-id='$item->id' class='btn btn-sm btn-danger delete'><i class='fa fa-trash'></i></button>";

                    return $buttons;
                })
                ->rawColumns(['options','attachments'])
                ->make(true);
        }

        return view('items.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        //$collection = (new FastExcel)->import(storage_path('app/26.xlsx'));

        //$collection = $collection->toArray();

        $components = Component::query()->get();

        return view('items.create', compact('components'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $components = $request->except(['name','code','notes','attachments','_token','_method']);

        $components = collect($components)->map(function ($e){
            return (double) $e;
        });


        $values = [];

        foreach($components as $key => $value)
        {
            $values[$key] = ['concentration' => $value];
        }

        //

        for ($i=1;$i<=26;$i++){

            $inputs[$i] = "numeric|between:0.00010,99999";
        }


        $validate = [
            'name' => 'required|min:3|max:255',
            'code' => 'required|min:3|max:255|unique:items,code',
            'attachments' => 'file|mimes:pdf,docx,rtf,excel|max:10000',
        ];

        $validate = $validate + $inputs;


        $this->validate($request,$validate);

        $components = $request->except(['name','code','notes','attachments','_token']);



        $item = Item::query()->create($request->all(['name','code','notes']));

        $values = [];

        foreach($components as $key => $value)
        {
            $values[$key] = ['concentration'=>$value];
        }

        $item->components()->sync($values);

        $item->update(['concentration_sum'=> $item->componentsSum()]);

        if($request->hasFile('attachments')){
            $item->attach($request->file('attachments'),[
                'key' => 'attachments',
                'disk'=>'public'
            ]);
        }

        flash('Item Has been Created!')->success();

        return back();
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        //

        //$collection = (new FastExcel)->import(storage_path('app/26.xlsx'));

        //$collection = $collection->toArray();


        return view('items.import');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function importStore(Request $request)
    {
        $this->validate($request,[
            'excel_file' =>  'required|file|mimes:xlsx|max:10000'
        ]);

        $collection = (new FastExcel)->import($request->file('excel_file'));

        $collection = $collection->take(1000);

        foreach ($collection as $value){

            if(count($value) === 28){

                $item_inputs = array_values(array_slice($value,0,2));

                $item = Item::query()->create([
                    'code'=> str_limit($item_inputs[0],255,''),
                    'name'=> str_limit($item_inputs[1],255,''),
                ]);

                //$item_components = array_keys(array_slice($value,2,26));

                $item_components_per = array_values(array_slice($value,2,26));

                $values = [];

                foreach($item_components_per as $key => $per_value)
                {
                    $values[$key+1] = ['concentration'=>is_numeric($per_value) ? $per_value : 0.00100];
                }


                $item->components()->sync($values);

                $item->update(['concentration_sum'=> $item->componentsSum()]);

            }else{
                continue;
            }
        }

        flash('Item Has been Imported!')->success();

        return back();
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
        $item->load(['components']);

        return view('items.show', compact('item'));

        // $item->components()->attach([1, 2]);

        /*return $item->load(['components'=> function($q){
            $q->wherePivot('concentration',0.00100);
        }]);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //

        $item->load(['components']);

        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
        $components = $request->except(['name','code','notes','attachments','_token','_method']);

        $components = collect($components)->map(function ($e){
            return (double) $e;
        });


        $values = [];

        foreach($components as $key => $value)
        {
            $values[$key] = ['concentration' => $value];
        }

        //

        for ($i=1;$i<=26;$i++){

            $inputs[$i] = "numeric|between:0.00010,99999";
        }


        $validate = [
            'name' => 'required|min:3|max:255',
            'code' => 'required|min:3|max:255|unique:items,code,'.$item->id,
            'attachments' => 'file|mimes:pdf,docx,rtf,excel|max:10000',
        ];

        $validate = $validate + $inputs;


        $this->validate($request,$validate);


        $components = $request->except(['name','code','notes','attachments','_token','_method']);


        $item->update($request->all(['name','code','notes']));

        $values = [];

        foreach($components as $key => $value)
        {
            $values[$key] = ['concentration'=>$value];
        }

        $item->components()->sync($values);

        $item->update(['concentration_sum'=> $item->componentsSum()]);

        if($request->hasFile('attachments')){

            if($item->attachment('attachments')){

                $item->attachment('attachments')->delete();
            }

            $item->attach($request->file('attachments'),[
                'key' => 'attachments',
                'disk'=>'public'
            ]);
        }

        flash('Item Has been Updated!')->success();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
        return response()->json($item->delete(),200);

    }
}
