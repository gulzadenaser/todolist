@extends('layouts.app')

@section('content')

<div class="container">
<div class="card">
  <div class="card-header"><h3>Update Category</h3></div>
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
     {{ Form::model($category, array('route' => array('category.update', $category->id), 'method' => 'POST','class' => 'form validity')) }}
        {{ method_field('PATCH') }}
       <div class="row">

        <div class="col-sm-6">
        <div class="form-group">
          <label class="font-normal required"><strong>Name</strong></label>
            <div class="input-group date">
                <input type="text" class="form-control input-sm" value="{{ $category->name }}" id="name" name="name" required>
            </div>
        </div>
        <div class="form-group pt-2">
            <button type="submit" name="submit" id="submit" value="Submit" class="btn btn-success pull-right" required="required">Update</button>
        </div>
        </div>
        {{ Form::close() }} 
    </div>
   </div>
  </div>
</div>


<div class="container">
    
    @include('category.list') 
</div>

@endsection
@push('css')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/buttons.datatables.min.css') }}" rel="stylesheet">
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
</style>
@endpush
@push('js')
<script src="{{ asset('js/datatables.min.js') }}"></script>
<script src="{{ asset('js/datatable/buttons.min.js') }}"></script>
<script src="{{ asset('js/datatable/html5.min.js') }}"></script>
<script src="{{ asset('js/datatable/print.min.js') }}"></script>
<script src="{{ asset('js/datatable/jszip.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('#categorylisttable').DataTable({
    //let table = new DataTable('#buylisttable', {
        ajax: function (d, cb) {
            fetch('/categorylist')
                .then(response => response.json())
                .then(data => cb(data));
        },
        
        columns: [
            { data: 'no' },
            { data: 'name' },
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
