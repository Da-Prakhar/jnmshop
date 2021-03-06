@extends('admin.layouts.master-soyuz')
@section('title','Edit Your Bank Details')
@section('body')

@component('admin.component.breadcumb',['thirdactive' => 'active'])

@slot('heading')
{{ __('Home') }}
@endslot

@slot('menu1')
{{ __(" Bank Details") }}
@endslot

@slot('menu2')
{{ __(" Bank Details") }}
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
          <h5 class="box-title">{{ __('Edit') }} {{ __(' Bank Details') }}</h5>
        </div>
        <div class="card-body">
          <form id="demo-form2" method="post" enctype="multipart/form-data" action="{{url('admin/bank_details/')}}"
          data-parsley-validate class="form-horizontal form-label-left">
          {{csrf_field()}}
     
       
         <div class="row">
      
          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
              Enable Bank transfer on checkout page:
            </label>
            <br>
      
              <label class="switch">
                <input type="checkbox" name="BANK_TRANSFER" {{ env('BANK_TRANSFER') == 1 ? "checked" : "" }}>
                <span class="knob"></span>
              </label>
      
          </div>
      
          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
              Bank Name <span class="required">*</span>
            </label>
      
              <input placeholder="Please enter bank name" type="text" id="first-name" name="bankname"
                class="form-control" value="{{$bank->bankname ?? ''}} ">
      
          </div>

          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
              Branch Name <span class="required">*</span>
            </label>
      
              <input placeholder="Please enter branch name" type="text" id="first-name" name="branchname"
                class="form-control" value="{{$bank->branchname ?? ''}} ">
      
          </div>


          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
              IFSC Code <span class="required">*</span>
            </label>
      
              <input placeholder="Enter IFSC code" type="text" id="first-name" name="ifsc"
                class="form-control col-md-12" value="{{$bank->ifsc ?? ''}} ">
      
          </div>


          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
              SWIFT Code:
            </label>
      
              <input placeholder="Enter SWIFT code" type="text" id="first-name" name="swift_code"
                class="form-control col-md-12" value="{{$bank->swift_code ?? ''}}">
      
          </div>


          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
              Account Number <span class="required">*</span>
            </label>
      
              <input placeholder="Enter account no." type="text" id="first-name" name="account"
                class="form-control col-md-12" value="{{$bank->account ?? ''}}">
      
          </div>


          <div class="form-group col-md-6">
            <label class="control-label" for="first-name">
              Account Name <span class="required">*</span>
            </label>
      
              <input placeholder="Enter account name" type="text" id="first-name" value="{{$bank->acountname ?? ''}}"
                name="acountname" class="form-control col-md-12">
      
          </div>

      
          <div class="form-group col-md-12">
            <button @if(env('DEMO_LOCK')==0) type="reset"  @else disabled title="This operation is disabled is demo !" @endif  class="btn btn-danger-rgba"><i class="fa fa-ban"></i> Reset</button>
            <button @if(env('DEMO_LOCK')==0)  type="submit" @else disabled title="This operation is disabled is demo !" @endif  class="btn btn-primary-rgba"><i class="fa fa-check-circle"></i>
                Update</button>
        </div>
        <div class="clear-both"></div>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
