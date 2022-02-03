@extends('admin.layouts.master-soyuz')
@section('title','Create a Brand')
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __("Complain") }}
@endslot

@slot('menu2')
{{ __("") }}
@endslot
@slot('button')

<div class="col-md-6">
  <div class="widgetbar">
  <a href="{{url('admin/compaints')}}" class="btn btn-primary-rgba mr-2"><i
      class="feather icon-arrow-left mr-2"></i>Back</a>
</div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  <div class="row">
    
    <div class="col-lg-12">

      @if ($errors->any())
        <div class="alert alert-danger" role="alert">
          @foreach($errors->all() as $error)
          <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true" style="color:red;">&times;</span></button></p>
          @endforeach
        </div>
      @endif

      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title">{{ __('Add') }} {{ __('Complain') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data"
        action="{{url('admin/compaints')}}" data-parsley-validate class="form-horizontal form-label-left">
        {{csrf_field()}}
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
         
          <label class="control-label" for="first-name">
            Complain Ref No: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Complain Ref No" type="text"  name="complain_ref_no"
              class="form-control col-md-12">
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Complain by User ID: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Complain by User ID" type="text"  name="complain_by_user_id"
              class="form-control col-md-12">

         
            
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Complain by Name: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Complain by Name" type="text"  name="complain_by_name"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Mobile: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Mobile" type="text"  name="mobile"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Title: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Title" type="text"  name="title"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Issue Date: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Issue Date" type="text"  name="issue_date"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Resolved Date: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Resolved Date" type="text"  name="resolved_date"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Category: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Category" type="text"  name="category"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Sub category: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Sub category" type="text"  name="sub_category"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Mentioned complain: <span class="required">*</span>
          </label>

            <input placeholder="Please enter Mentioned complain" type="text"  name="mentioned_complain"
              class="form-control col-md-12">

         
        </div></div>
        <div class="col-md-6">
        <div class="form-group">
          <label class="control-label" for="first-name">
            Photo: <span class="required">*</span>
          </label>

        
            <div class="input-group mb-3">

              <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
              </div></div>

            </div> 
              <div class="custom-file">
                <input type="file" name="photo" class="inputfile inputfile-1" id="inputGroupFile01"
                  aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
              </div>
            </div>            
            <small class="text-info"> <i class="text-dark feather icon-help-circle"></i>(Please Choose photo Image)</small>

                
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
      </div>
    </div>
  </div>
</div>
@endsection
