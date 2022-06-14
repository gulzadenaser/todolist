@extends('layouts.app')

@section('content')

<div class="container">
<div class="card">
  <div class="card-header"><h3>Register New Vehicle</h3></div>
     <div class="card-body">  
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif   
        @if(session()->has('error'))
            <div class="alert alert-warning">
                {{ session()->get('error') }}
            </div>
        @endif   
     {!! Form::open(['method' => 'POST', 'route' => ['vehicle.store'] ]) !!} 
       <div class="row">

        <div class="col-sm-6">

        <div class="form-group">
            <label for="firm" class="font-normal required"><strong>Company</strong></label>
            <div class="input-group date">
                <select data-placeholder="Choose a category..." required="required" class="chosen-select" id="category_id" name="category_id" searchable="Search here..">
                <option value="" selected>Choose a category</option>
                @foreach($categories as $category)
                   <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
                </select>
            </div>
        </div>
        <div class="form-group">
          <label class="font-normal required"><strong>Color</strong></label>
            <div class="input-group date">
                <input type="text" class="form-control input-sm" value="" id="color" name="color" required>
            </div>
        </div>
        <div class="form-group">
        <label class="font-normal required"><strong>Model</strong></label>
            <div class="input-group date">
                <input type="text" class="form-control input-sm" value="" id="model" name="model" required>
            </div>
        </div>
        </div>

        <div class="col-sm-6">

        <div class="form-group">
            <label class="font-normal required"><strong>Make</strong></label>
            <div class="input-group date">
                <input type="text" class="form-control input-sm" value="" id="make" name="make" required>
            </div>
        </div>
        <div class="form-group">
            <label class="font-normal required"><strong>Registration Number</strong></label>
            <div class="input-group date">
                <input type="text" class="form-control input-sm" value="" id="registration_no" name="registration_no" required>
            </div>
        </div>
        <div class="form-group pt-4">
            <button type="submit" name="submit" id="submit" value="Submit" class="btn btn-success pull-right" required="required">Register</button>
        </div>

        </div>
        {{ Form::close() }} 
    </div>
   </div>
  </div>
</div>


<div class="container">
    
    @include('vehicles.list') 
</div>

@endsection
@push('css')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/buttons.datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
<style>
.required:after {
  content:" *";
  color: red;
}

legend.scheduler-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
}
.chosen {
  font-family: Arial !important; 
  font-size: 15px;
}
.chosen-small .chosen-container .chosen-results {
    max-height: 150px !important;
}
.chosen-medium .chosen-container .chosen-results {
    max-height: 250px !important;
}
.chosen-large .chosen-container .chosen-results {
    max-height: 350px !important;
}
select:invalid {
  height: 0px !important;
  opacity: 0 !important;
  position: absolute !important;
  display: flex !important;
}

select:invalid[multiple] {
  margin-top: 15px !important;
}
</style>
@endpush
@push('js')
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.min.js') }}"></script>
<script src="{{ asset('js/datatable/html5.min.js') }}"></script>
<script src="{{ asset('js/datatable/print.min.js') }}"></script>
<script src="{{ asset('js/datatable/jszip.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('select').chosen({
       allow_single_deselect: true
    });
    $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
    $(".chosen-results").css({'font-size':'14px', 'max-height':'250px'});
    $(".chosen-container").css({'font-size':'14px', 'max-height':'250px'});
    $('#vehiclelisttable').DataTable({
    //let table = new DataTable('#buylisttable', {
        ajax: function (d, cb) {
            fetch('/vehiclelist')
                .then(response => response.json())
                .then(data => cb(data));
        },
        
        columns: [
            { data: 'no' },
            { data: 'category' },
            { data: 'color' },
            { data: 'model' },
            { data: 'make'},
            { data: 'registration_no' },
            { data: 'edit_btn' },
            { data: 'del_btn' },
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy','excel','print'
        ],
    } );
 
});
</script>
@endpush
