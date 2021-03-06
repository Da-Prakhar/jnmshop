@extends('admin.layouts.master-soyuz')
@section('title','Create a SubCategory')
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("SubCategory") }}
@endslot

@slot('menu2')
{{ __("SubCategory") }}
@endslot
@slot('button')
<div class="col-md-6">
  <div class="widgetbar">

  <a href="{{url('admin/subcategory')}}" class="btn btn-primary-rgba mr-2"><i
      class="feather icon-arrow-left mr-2"></i>Back</a>
</div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  <div class="row">
    @if ($errors->any())
    <div class="alert alert-danger" role="alert">
      @foreach($errors->all() as $error)
      <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true" style="color:red;">&times;</span></button></p>
      @endforeach
    </div>
    @endif
    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Add') }} {{ __('SubCategory') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/subcategory')}}"
            data-parsley-validate class="form-horizontal form-label-left">
            {{csrf_field()}}
            <div class="form-group">
              <label class="control-label" for="first-name">
                Parent Category: <span class="required">*</span>
              </label>
              <div class="row">
                <div class="col-md-10">
                  <select name="parent_cat" class="form-control select2 col-md-12">

                    @foreach($parent as $p)
                    <option value="{{$p->id}}">{{$p->title}}</option>
                    @endforeach
                  </select>
                  <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(Please Choose Parent
                    Category)</small>

                </div>
                <div class="col-md-2">
                  @can('category.create')
                  <button type="button" data-toggle="modal" data-target="#myModal"
                    class="btn btn-md btn-primary">+</button>
                  @endcan
                </div>
              </div>

            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                Subcategory: <span class="required">*</span>
              </label>

              
                <input placeholder="Please enter Subcategory name" type="text" id="first-name" name="title"
                  class="form-control col-md-12">

             

            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> Description: <span class="required">*</span>
              </label>
          
                <textarea cols="2" id="editor1" name="description" rows="5">
                           </textarea>
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(Please Enter
                  Description)</small>

          
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                Icon:
              </label>
          
                <div class="input-group">
                  <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                  <span class="input-group-append">
                    <button type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                  </span>
              


              </div>
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name"> Image:
              </label>
              <div class="input-group mb-3">

                <div class="input-group-prepend">
                  <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                </div>


                <div class="custom-file">

                  <input type="file" name="name" class="inputfile inputfile-1" id="first-name"
                    aria-describedby="inputGroupFileAddon01">
                  <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
              </div>  
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(Please Choose
                  image)</small>

             
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                Featured:
              </label>
              <br>
                <label class="switch">
                  <input class="slider tgl tgl-skewed" type="checkbox" id="featured" checked="checked">
                  <span class="knob"></span>
                </label>
                <br>
                <input type="hidden" name="featured" value="1" id="featured">
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(If enabled than Subcategory
                  will be featured)</small>

             
            </div>
            <div class="form-group">
              <label class="control-label" for="first-name">
                Status: <span class="required">*</span>
              </label>
              <br>
                <label class="switch">
                  <input class="slider tgl tgl-skewed" type="checkbox" id="status" checked="checked">
                  <span class="knob"></span>
                </label>
                <br>
                <input type="hidden" name="status" value="1" id="status3">
                <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(Please Choose
                  Status)</small>
            
            </div>
            <div class="form-group">
              <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                Reset</button>
              <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                Create</button>
            </div>

            <div class="clear-both"></div>
          </form>

        </div>
        <!-- /.box -->

        @can('category.create')

        <div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Add Category</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
              </div>

              <div class="modal-body">
                <form enctype="multipart/form-data" action="{{ route('quick.cat.add') }}" method="POST">
                  {{ csrf_field() }}
                  <label for="">Category Name:</label>
                  <input required type="text" class="form-control" placeholder="Enter category name" name="title" />
                  <br>
                  <label for="">Description:</label>
                  <textarea name="detail" id="editor2" cols="30" rows="10"></textarea>
                  <br>

                  <label for="">Icon:</label>
                  <div class="input-group">
                    <input type="text" class="form-control iconvalue" name="icon" value="Choose icon">
                    <span class="input-group-append">
                        <button  type="button" class="btnicon btn btn-outline-secondary" role="iconpicker"></button>
                    </span>
                </div>
                 

                  <br>
                  <label for="">Category Image:</label>
                  <div class="input-group mb-3">

                    <div class="input-group-prepend">
                      <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                    </div>
    
    
                    <div class="custom-file">
    
                      <input type="file" name="image" class="inputfile inputfile-1" id="inputGroupFile01"
                        aria-describedby="inputGroupFileAddon01">
                      <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                    </div>
                  </div>                  <br>
                  <label for="">Status:</label>
                  <label class="switch">
                    <input class="slider tgl tgl-skewed" type="checkbox" id="status4" checked="checked">
                    <span class="knob"></span>
                  </label>
                  <br>
                  <input type="hidden" name="status" value="1" id="status4">
                  <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(Please Choose
                    Status)</small>

                  <br>
                  <label for="">Featured:</label>
                  <label class="switch">
                    <input class="slider tgl tgl-skewed" type="checkbox" id="status5" checked="checked">
                    <span class="knob"></span>
                  </label>
                  <br>
                  <input type="hidden" name="featured" value="1" id="status5">
                  <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(Please Choose
                    Feature)</small>
                  <br>
                  <div class="form-group">
                    <button type="reset" class="btn btn-danger"><i class="fa fa-ban"></i>
                      Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-check-circle"></i>
                      Create</button>
                  </div>

                  <div class="clear-both"></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
</div>

@endcan

@endsection