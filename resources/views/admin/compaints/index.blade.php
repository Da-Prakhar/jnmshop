@extends('admin.layouts.master-soyuz')
@section('title','All Complains')
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('All Complains') }}
@endslot
@slot('menu1')
{{ __('Complains') }}
@endslot

@slot('button')

<div class="col-md-6">
  <div class="widgetbar">    
    <a href=" {{url('admin/compaints/create')}} " class="btn btn-primary-rgba mr-2">
      <i class="feather icon-plus mr-2"></i> {{__("Add Compain")}}
    </a>
  </div>
</div>
@endslot
@endcomponent

<div class="contentbar">
  <div class="row">

    <div class="col-lg-12">
      <div class="card m-b-30">
        <div class="card-header">
          <h5 class="box-title"> All Complains</h5>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table id="compainsTable" class="width100 table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Sr. No.</th>
                  <th>Complain Ref No</th>
                  <th>Complain by User ID</th>
                  <th>Complain by Name</th>
                  <th>Mobile</th>
                  <th>Title</th>
                  <th>Issue Date</th>
                  <th>Resolved Date</th>
                  <th>Category</th>
                  <th>Sub category</th>
                  <th>Mentioned complain</th>
                  <th>Photo</th>                  
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--  -->

@endsection
@section('custom-script')
<script>
  var url = @json(route('compaints.index'));
</script>
<script src="{{ url('js/complains.js') }}"></script>
@endsection