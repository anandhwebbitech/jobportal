@extends('admin.layouts.master')
@section('title', 'Resume Plan List')

@section('content')
<main class="main" id="main">

<div class="row g-4 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Resume Plan List</h2>
        <button class="btn btn-primary" id="createPlanModalBtn">+ Add Plan</button>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle" id="plan-table">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Plan</th>
                        <th>Price</th>
                        <th>Downloads</th>
                        <th>Validity</th>
                        <th>Status</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="planModal">
<div class="modal-dialog modal-lg">
<div class="modal-content">

<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Create Plan</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
</div>

<div class="modal-body">
<form id="planForm">
@csrf

<input type="hidden" id="plan_id">

<div class="row g-3">

<div class="col-md-6">
    <label>Plan Name</label>
    <input type="text" name="name" id="plan_name" class="form-control">
</div>

<div class="col-md-3">
    <label>Downloads</label>
    <input type="number" name="downloads_limit" id="plan_downloads" class="form-control">
</div>

<div class="col-md-3">
    <label>Validity (Days)</label>
    <input type="number" name="valid_days" id="plan_validity" class="form-control">
</div>

<div class="col-md-4">
    <label>Price</label>
    <input type="number" name="price" id="plan_price" class="form-control">
</div>

<div class="col-md-4">
    <label>GST (18%)</label>
    <input type="text" id="plan_gst" class="form-control" readonly>
    <input type="hidden" name="gst_amount" id="gst_hidden">
</div>

<div class="col-md-4">
    <label>Total</label>
    <input type="text" id="plan_total" class="form-control" readonly>
    <input type="hidden" name="total_price" id="total_hidden">
</div>

<div class="col-md-6">
    <label>Status</label>
    <select name="is_active" id="plan_status" class="form-select">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
</div>

</div>

<hr>

<h6>Features</h6>
<div class="row">
@foreach(['full_profile_access','advanced_filters','export_excel_pdf','priority_support','whatsapp_support'] as $f)
<div class="col-md-4 mt-2">
    <div class="form-check">
        <input type="checkbox" class="form-check-input feature" value="{{ $f }}">
        <label>{{ ucwords(str_replace('_',' ',$f)) }}</label>
    </div>
</div>
@endforeach
</div>

<button class="btn btn-success w-100 mt-4">Save Plan</button>

</form>
</div>

</div>
</div>
</div>

</main>
@endsection
@push('scripts')
<script>
$(function(){

let modalMode = 'create';

const table = $('#plan-table').DataTable({
    processing:true,
    serverSide:true,
    ajax:"{{ route('admin.resumeplans.index') }}",
    columns:[
        {data:'DT_RowIndex', orderable:false, searchable:false},
        {data:'name'},
        {data:'price_html'},
        {data:'downloads_limit'},
        {data:'valid_days'},
        {data:'status_html'},
        {data:'action', orderable:false}
    ]
});


// GST
$('#plan_price').on('input', function(){
    let price = parseFloat(this.value) || 0;
    let gst = price * 0.18;
    let total = price + gst;

    $('#plan_gst').val(gst.toFixed(2));
    $('#plan_total').val(total.toFixed(2));

    $('#gst_hidden').val(gst);
    $('#total_hidden').val(total);
});


// CREATE
$('#createPlanModalBtn').click(function(){
    modalMode = 'create';
    $('#planForm')[0].reset();
    $('.feature').prop('checked',false);
    $('#planModal').modal('show');
});


// EDIT
$(document).on('click','.editPlan',function(){

    modalMode='edit';
    let url = $(this).data('edit');

    $('#planForm')[0].reset();
    $('.feature').prop('checked',false);

    $.get(url,function(res){

        $('#plan_id').val(res.id);
        $('#plan_name').val(res.name);
        $('#plan_downloads').val(res.downloads_limit);
        $('#plan_validity').val(res.valid_days);
        $('#plan_price').val(res.price).trigger('input');
        $('#plan_status').val(res.is_active);

        if(res.features){
            let features = res.features;

            if(typeof features === "string"){
                features = JSON.parse(features);
            }

            features.forEach(f=>{
                $('.feature[value="'+f+'"]').prop('checked',true);
            });
        }

        $('#planModal').modal('show');
    });

});


// SUBMIT
$('#planForm').submit(function(e){
    e.preventDefault();

    let features=[];
    $('.feature:checked').each(function(){
        features.push($(this).val());
    });

    let formData = $(this).serialize() + '&features='+JSON.stringify(features);

    let url = modalMode==='create'
        ? "{{ route('admin.resumeplans.store') }}"
        : "{{ url('admin/resume-plans') }}/"+$('#plan_id').val();

    $.ajax({
        url:url,
        type:'POST',
        data:formData,
        success:function(res){
            toastr.success(res.message);
            $('#planModal').modal('hide');
            table.ajax.reload();
        }
    });

});


// DELETE
$(document).on('click','.deletePlan',function(){

    if(!confirm('Are you sure want to delete this plan?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('admin/resume-plans') }}/"+id,
        type: "DELETE",
        data: {_token: "{{ csrf_token() }}"},
        success: function(res){
            toastr.success(res.message);
            table.ajax.reload();
        }
    });

});

});
</script>
@endpush