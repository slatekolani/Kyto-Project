<?php

namespace App\Http\Controllers\tourOperatorAccounts;

use App\Http\Controllers\Controller;
use App\Models\paymentGateways\paymentGateways;
use App\Models\tourOperatorAccounts\tourOperatorAccounts;
use App\Models\tourOperators\tourOperators;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class tourOperatorAccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_operator_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operator_id)->first();
        return view('tourOperatorAccounts.index')->with('tour_operator',$tour_operator);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($tour_operators_id)
    {
        $tour_operator=tourOperators::query()->where('uuid',$tour_operators_id)->first();
        $payment_gateway=paymentGateways::where('status','=',1)->pluck('payment_gateway_name','id');
        return view('tourOperatorAccounts.create')
            ->with('tour_operator',$tour_operator)
            ->with('payment_gateway',$payment_gateway);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tour_operator_account=new tourOperatorAccounts();
        $tour_operator_account->payment_gateway=$request->input('payment_gateway');
        $tour_operator_account->account_name=$request->input('account_name');
        $tour_operator_account->account_number=$request->input('account_number');
        $tour_operator_account->tour_operators_id=$request->input('tour_operators_id');
        $tour_operator_account->save();
        return redirect()->route('tourOperatorAccounts.index',$tour_operator_account->tourOperators->uuid)->withFlashSuccess('Account saved successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tour_operator_account_id)
    {
        $payment_gateway=paymentGateways::all()->pluck('payment_gateway_name','id');
        $tour_operator_account=tourOperatorAccounts::query()->where('uuid',$tour_operator_account_id)->first();
        return view('tourOperatorAccounts.edit')
            ->with('payment_gateway',$payment_gateway)
            ->with('tour_operator_account',$tour_operator_account);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tour_operator_account_id)
    {
        $tour_operator_account=tourOperatorAccounts::query()->where('uuid',$tour_operator_account_id)->first();
        $tour_operator_account->payment_gateway=$request->input('payment_gateway');
        $tour_operator_account->account_name=$request->input('account_name');
        $tour_operator_account->account_number=$request->input('account_number');
        $tour_operator_account->tour_operators_id=$request->input('tour_operators_id');
        $tour_operator_account->save();
        return redirect()->route('tourOperatorAccounts.index',$tour_operator_account->tourOperators->uuid)->withFlashSuccess('Payment account Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(tourOperatorAccounts $tour_operator_account)
    {
        $tour_operator_account->delete();
        return redirect()->route('tourOperatorAccounts.index',$tour_operator_account->tourOperators->uuid)->withFlashSuccess('Account removed successfully');
    }

    public function activateAccount(Request $request)
    {
        $tour_operator_account=tourOperatorAccounts::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $tour_operator_account->status=1;
                break;
            case 1:
                $tour_operator_account->status=0;
                break;
        }
        $tour_operator_account->save();
    }

    public function get_tour_operator_account($tour_operator_id)
    {
        $tour_operator=tourOperators::find($tour_operator_id);
        $tour_operator_account=tourOperatorAccounts::query()->orderBy('payment_gateway')->where('tour_operators_id',$tour_operator->id)->get();
        return DataTables::of($tour_operator_account)
            ->addIndexColumn()
            ->addColumn('payment_gateway',function ($tour_operator_account)
            {
               return paymentGateways::find($tour_operator_account->payment_gateway)->payment_gateway_name;
            })
            ->addColumn('account_name',function ($tour_operator_account)
            {
                return $tour_operator_account->account_name;
            })
            ->addColumn('account_number',function ($tour_operator_account)
            {
                return $tour_operator_account->account_number;
            })
            ->addColumn('activate_account',function($tour_operator_account)
            {
                $btn='<label class="switch{{$tour_operator_account->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('account_status',function($tour_operator_account){
                if($tour_operator_account->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })
//            ->addColumn('status',function ($tour_operator_account)
//            {
//                return $tour_operator_account->status_label;
//            })
            ->addColumn('action',function ($tour_operator_account)
            {
                $btn='<a href="'.route('tourOperatorAccounts.edit',$tour_operator_account->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('tourOperatorAccounts.delete',$tour_operator_account->uuid).'" class="btn btn-danger btn-sm">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','status','activate_account','account_status'])
            ->make(true);

    }
}
