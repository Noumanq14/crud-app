<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $companies = Company::orderBy('id','DESC')->get(['id','name','email','logo','website']);
        $data = [];
        foreach ($companies as $company)
            $company->logo = asset("storage/".$company->logo);

        return response()->json(['status' => 1,'data' => $companies]);

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
        //
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png'
        ]);

        if ($validator->fails())
            return response()->json(['status' => 0, 'message' => $validator->errors()],400);

        $imageWidth  = getimagesize($request->file('file'))[0];
        $imageHeight = getimagesize($request->file('file'))[1];

//        if ($imageWidth != 100 || $imageHeight != 100)
//            return response()->json(['status' => 0, 'message' => 'logo must be of 100x100'],400);

        $company = new Company();

        $company->name           = $request['name'];
        $company->email          = $request['email'];
        $company->website        = $request['companyWebsite'];

        $file_name = time().'_'.$request->file->getClientOriginalName();
        $file_path = $request->file('file')->storeAs('public',$file_name);

        if (!$file_path)
            return response()->json(['status' => 0, 'message' => 'Unable to upload image'],400);

        $company->logo = $file_name;

        $company->save();

        return response()->json(['status' => 1, 'message' => 'Company Added Successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $oldLogo = explode("/",$request["logo"])[4];
        $logoValidation = ($request["file"] != null) ? true : false;

        $validator = Validator::make($request->all(),[
            'name' => 'required'
        ]);

        if ($validator->fails())
            return response()->json(['status' => 0, 'message' => $validator->errors()],400);

        $company = Company::where('id',$id)->update([
            'name' => $request["name"],
            'email' => $request["email"],
            'website' => $request["companyWebsite"]
        ]);

        if ($logoValidation && $company)
        {
            $file_name = time().'_'.$request->file->getClientOriginalName();
            $file_path = $request->file('file')->storeAs('public',$file_name);

            if (!$file_path)
                return response()->json(['status' => 0, 'message' => 'Unable to upload image'],400);

            $logoCompany = Company::where('id',$id)->update(['logo' => $file_name]);

            if (Storage::exists('public/'.$oldLogo))
                Storage::delete('public/'.$oldLogo);

            if ($logoCompany)
                return response()->json(['status' => 1, 'message' => 'Company Updated Successfully']);
        }
        elseif ($company)
            return response()->json(['status' => 1, 'message' => 'Company Updated Successfully']);
        else
            return response()->json(['status' => 0, 'message' => 'Unable to update company']);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $company = Company::findOrFail($id);

        if ($company)
        {
            $companyLogo = $company->logo;
            if (Storage::exists('public/'.$companyLogo))
                Storage::delete('public/'.$companyLogo);
            $company->delete();
            return response()->json(['status' => 1, 'message' => 'Company Deleted Successfully']);
        }
        else
            return response()->json(['status' => 0, 'message' => 'Unable to delete company']);

    }
}
