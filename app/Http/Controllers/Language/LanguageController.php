<?php

namespace App\Http\Controllers\Language;

use App\Http\Controllers\Controller;
use App\Models\Languages\language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
    /**
     * @param $lang
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function swap($lang)
    {
        session()->put('locale', $lang);

        return redirect()->back();
    }
    public function index()
    {

        return view('Languages.index');
    }

    public function create()
    {
        return view('Languages.create');
    }
    public function store(Request $request)
    {
        $language=new language();
        $language->language_name=$request->input('language_name');
        if($request->hasFile('nation_language_flag'))
        {
            $file=$request->file('nation_language_flag');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/Languages/',$filename);
            $language->nation_language_flag=$filename;
        }
        $language->save();
        return redirect()->route('Language.index')->withFlashSuccess('Language populated successfully');
    }
    public function edit($language_id)
    {
        $language=language::query()->where('uuid',$language_id)->first();
        return view('Languages.edit')->with('language',$language);
    }

    public function update(Request $request, $language_id)
    {
        $language=language::query()->where('uuid',$language_id)->first();
        $language->language_name=$request->input('language_name');
        if($request->hasFile('nation_language_flag'))
        {
            $file=$request->file('nation_language_flag');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('public/Languages/',$filename);
            $language->nation_language_flag=$filename;
        }
        $language->save();
        return redirect()->route('Language.index')->withFlashSuccess('Language updated successfully');
    }

    public function destroy(language $language)
    {
        $language->delete();
        return redirect()->route('Language.index')->withFlashSuccess('Language removed successfully');
    }

    public function activateLanguage(Request $request)
    {
        $language=language::find($request->id);
        $status=$request->status;
        switch($status)
        {
            case 0:
                $language->status=1;
                break;
            case 1:
                $language->status=0;
                break;
        }
        $language->save();
    }

    public function get_language()
    {
        $language=language::query()->orderBy('language_name')->get();
        return DataTables::of($language)
            ->addIndexColumn()
            ->addColumn('nation_language_flag',function($language)
            {
                return $language->nation_language_flag_label;
            })
            ->addColumn('language_name',function ($language)
            {
                return $language->language_name;
            })
            ->addColumn('activate_language',function($language){
                $btn='<label class="switch{{$booking->status}}">
                          <input type="checkbox">
                          <span class="slider round"></span>
                        </label>';
                return $btn;
            })
            ->addColumn('language_status',function($language)
            {
                if($language->status==0)
                {
                    return '<span class="badge badge-pill badge-info">Inactive</span>';
                }
                else
                {
                    return '<span class="badge badge-pill badge-success">Active</span>';
                }
            })
            ->addColumn('action',function($language)
            {
                $btn='<a href="'.route('Language.edit',$language->uuid).'" class="btn btn-primary btn-sm">Edit</a>';
                $btn=$btn.'<a href="'.route('Language.delete',$language->uuid).'" class="btn btn-danger btn-sm disabled">Delete</a>';
                return $btn;
            })
            ->rawColumns(['action','status','activate_language','language_status'])
            ->make(true);
    }
}
