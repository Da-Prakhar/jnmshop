<?php
namespace App\Http\Controllers;

use App\Complaint;
use Image;
use Illuminate\Http\Request;
use DataTables;
use Avatar;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        abort_if(!auth()->user()->can('brand.view'),403,'User does not have the right permissions.');

        $complaints = Complaint::get();
        
        

        if ($request->ajax())
        {
            return DataTables::of($complaints)->addIndexColumn()->addColumn('photo', function ($row)
            {
                $photo = @file_get_contents('images/compains/'.$row->photo);

                if($photo){
                    $image= '<img style="object-fit:scale-down;"
                     width="100px" height="70px" src="' . url("images/compains/" . $row->photo) . '"/>';
                }else{
                    $image = '<img width="70px" height="70px" src="' . Avatar::create("blank")->toBase64() . '"/>';
                }                
                return $image;
            })->rawColumns(['photo', 'status', 'action'])
            ->make(true);
        }


        return view('admin.compaints.index', compact('complaints'));

    }

    public function requestedbrands()
    {
        abort_if(!auth()->user()->can('brand.view'),403,'User does not have the right permissions.');
        $complaints = Brand::where('is_requested', '=', '1')->where('status', '0')
            ->orderBy('id', 'DESC')
            ->get();
        return view('admin.brand.requestedbrand', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(!auth()->user()->can('brand.create'),403,'User does not have the right permissions.');
        return view("admin.compaints.add");
    }

    public function importbrands(Request $request){
        abort_if(!auth()->user()->can('brand.create'),403,'User does not have the right permissions.');

        $validator = Validator::make(
            [
                'file' => $request->file,
                'extension' => strtolower($request->file->getClientOriginalExtension()),
            ],
            [
                'file' => 'required',
                'extension' => 'required|in:xlsx,xls,csv',
            ]

        );

        if ($validator->fails()) {
            notify()->error('Invalid file !');
            return back();
        }

        $filename = 'brands_'.time() . '.' . $request->file->getClientOriginalExtension();

        Storage::disk('local')->put('/excel/'.$filename,file_get_contents($request->file->getRealPath()));

        $complaints = fastexcel()->import(storage_path().'/app/excel/'.$filename);

        if(count($complaints)){

            $complaints->each(function($brand){
                

               Brand::create([
                   
                    'name'          => $brand['name'],
                    'status'        => (string) $brand['status'],
                    'category_id'   => explode(',',$brand['category_id']),
                    'show_image'    => $brand['show_image'],
                    'image'         => $brand['image']

               ]);

            });

            Storage::delete('/excel/'.$filename);

            notify()->success('Brands imported successfully');

            return back();

        }else{
            notify()->error('File is empty !');
            return back();
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        abort_if(!auth()->user()->can('brand.create'),403,'User does not have the right permissions.');    

        $input = $request->all();
        unset($input ['_token']);
        if ($file = $request->file('photo'))
        {

            $img = Image::make($file->path());
            $destinationPath = public_path() . '/images/compains/';
            $image = time() . $file->getClientOriginalName();
            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($destinationPath . $image);

            $input['photo'] = $image;
        }        

        $data = Complaint::forceCreate($input);

        return back()
            ->with("added", "Complain Has Been Created !");
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(!auth()->user()->can('brand.edit'),403,'User does not have the right permissions.');
        $brand = Brand::findOrFail($id);
        return view("admin.brand.edit", compact("brand"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        abort_if(!auth()->user()->can('brand.edit'),403,'User does not have the right permissions.');

        $data = $this->validate($request, [

        "name" => "required|unique:brands,name,$id",

        ], [

        "name.required" => "Brand Name is required",

        ]);

        $brand = Brand::findOrFail($id);

        $input = $request->all();

        if ($file = $request->file('image'))
        {

            if ($brand->image != null)
            {

                if (file_exists(public_path() . '/images/brands/' . $brand->image))
                {
                    unlink(public_path() . '/images/brands/' . $brand->image);
                }

            }

            $img = Image::make($file);
            $destinationPath = public_path() . '/images/brands/';
            $name = time() . $file->getClientOriginalName();

            $img->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            });

            $img->save($destinationPath . $name);

            $input['image'] = $name;

        }

        if(isset($request->status)){
            $input['status'] = '1';
        }else{
            $input['status'] = '0';
        }

        if(isset($request->show_image)){
            $input['show_image'] = '1';
        }else{
            $input['show_image'] = '0';
        }

        $brand->update($input);

        return redirect('admin/brand')->with('updated', 'Brand has been updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        abort_if(!auth()->user()->can('brand.delete'),403,'User does not have the right permissions.');

        $obj = Brand::findorFail($id);

        if ($obj
            ->products
            ->count() < 1)
        {
            if ($obj->image != null)
            {
                $image_file = @file_get_contents(public_path() . '/images/brand/' . $obj->image);

                if ($image_file)
                {
                    unlink(public_path() . '/images/brand/' . $obj->image);
                }
            }
            $value = $obj->delete();
            if ($value)
            {
                session()->flash("deleted", "Brand Has Been deleted");
                return redirect("admin/brand");
            }
        }
        else
        {
            return back()
                ->with('warning', 'Brand cannot be deleted as its linked to some products !');
        }

    }

}

