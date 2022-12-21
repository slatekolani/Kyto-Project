<?php

namespace App\Http\Controllers\paymentGateways;

use App\Http\Controllers\Controller;
use App\Models\paymentGateways\paymentGateways;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use function foo\func;

class paymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paymentGateways.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('paymentGateways.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payment_gateway=new paymentGateways();
        $payment_gateway->payment_gateway_name=$request->input('payment_gateway_name');
        if($request->hasFile('payment_gateway_image'))
        {
            $file=$request->file('payment_gateway_image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/PaymentGatewayImages/images/',$filename);
            $payment_gateway->payment_gateway_image=$filename;
        }
        $payment_gateway->save();
        return redirect()->route('paymentGateway.index')->withFlashSuccess('Gateway populated successful');
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
    public function edit($payment_gateway_id)
    {
        $payment_gateway=paymentGateways::query()->where('uuid',$payment_gateway_id)->first();
        return view('paymentGateways.edit')->with('payment_gateway',$payment_gateway);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $payment_gateway_id)
    {
        $payment_gateway=paymentGateways::query()->where('uuid',$payment_gateway_id)->first();
        $payment_gateway->payment_gateway_name=$request->input('payment_gateway_name');
        if($request->hasFile('payment_gateway_image'))
        {
            $file=$request->file('payment_gateway_image');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/PaymentGatewayImages/images/',$filename);
            $payment_gateway->payment_gateway_image=$filename;
        }
        $payment_gateway->save();
        return redirect()->route('paymentGateway.index')->withFlashSuccess('Payment gateway updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(paymentGateways $payment_gateway)
    {
        $payment_gateway->delete();
        return redirect()->route('paymentGateway.index')->withFlashSuccess('Gateway removed successfully');
    }

    public function activateGateway(Request $request)
    {
        $payment_gateway=paymentGateways::find($request->id);
        $status=$request->status;
        switch ($status)
        {
            case 0:
                $payment_gateway->status=1;
                break;
            case 1:
                $payment_gateway->status=0;
                break;
        }
        $payment_gateway->save();
    }

    public function get_payment_gateways()
    {
        $payment_gateway=paymentGateways::query()->orderBy('payment_gateway_name')->get();
        return DataTables::of($payment_gateway)
            ->addIndexColumn()
            ->addColumn('payment_gateway_image',function ($payment_gateway)
            {
                return $payment_gateway->icon_gateway_label;
            })

            ->addColumn('payment_gateway_name',function($payment_gateway)
            {
                return $payment_gateway->payment_gateway_name;
            })

            ->addColumn('activate_gateway',function($payment_gateway){
                $btn='<label class="switch{{$payment_gateway->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })

            ->addColumn('gateway_status',function($payment_gateway){
                if($payment_gateway->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })

            ->addColumn('action',function ($payment_gateway)
            {

                $btn='<a href="'.route('paymentGateway.edit',$payment_gateway->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('paymentGateway.delete',$payment_gateway->uuid).'" class="btn btn-danger btn-sm disabled">Remove</a>';
                return $btn;
          })
            ->rawColumns(['action','activate_gateway','gateway_status'])
            ->make('true');
    }
}
