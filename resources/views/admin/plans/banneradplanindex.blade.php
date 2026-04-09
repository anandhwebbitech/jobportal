@extends('admin.layouts.master')
@section('title', 'Banner Plan List')

@section('content')
<main class="main" id="main">

<div class="row g-4 mb-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Banner Ad Plans</h2>
        <button class="btn btn-primary" id="createPlanModalBtn">+ Add Banner Plan</button>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover align-middle" id="plan-table">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Plan</th>
                        <th>Placement</th>
                        <th>Duration</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th width="150">Action</th>
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
    <h5 class="modal-title">Create Banner Plan</h5>
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

<div class="col-md-6">
    <label>Placement</label>
    <select name="placement" id="plan_placement" class="form-select">
        <option value="Home Page">Home Page</option>
        <option value="Sidebar">Sidebar</option>
    </select>
</div>

<div class="col-md-6">
    <label>Duration (Days)</label>
    <input type="number" name="duration_days" id="plan_duration" class="form-control">
</div>

<div class="col-md-6">
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

<div class="col-md-4">
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
@foreach(['image_banner','multi_position','high_visibility','prime_placement'] as $f)
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
    ajax:"{{ route('admin.bannerplans.index') }}",
    columns:[
        {data:'DT_RowIndex', orderable:false},
        {data:'name'},
        {data:'placement'},
        {data:'duration_days'},
        {data:'price_html'},
        {data:'status_html'},
        {data:'action', orderable:false}
    ]
});


// GST CALC
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

    modalMode = 'edit';

    let url = $(this).attr('data-edit'); // ✅ FIXED

    // reset form
    $('#planForm')[0].reset();
    $('.feature').prop('checked', false);

    $.ajax({
        url: url,
        type: 'GET',
        success: function(res){

            $('#plan_id').val(res.id);
            $('#plan_name').val(res.name);
            $('#plan_placement').val(res.placement);
            $('#plan_duration').val(res.duration_days);
            $('#plan_price').val(res.price).trigger('input');
            $('#plan_status').val(res.is_active);

            // features
            if(res.features){
                let features = res.features;

                if(typeof features === "string"){
                    features = JSON.parse(features);
                }

                features.forEach(f=>{
                    $('.feature[value="'+f+'"]').prop('checked', true);
                });
            }

            $('#planModal').modal('show');
        },
        error: function(){
            toastr.error('Failed to fetch data');
        }
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
        ? "{{ route('admin.bannerplans.store') }}"
        : "{{ url('admin/banner-plans') }}/"+$('#plan_id').val();

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
$(document).on('click','.deletePlan',function(){

    if(!confirm('Delete this plan?')) return;

    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('admin/banner-plans') }}/"+id,
        type: "DELETE",
        data: {_token: "{{ csrf_token() }}"},
        success: function(res){
            toastr.success(res.message);
            $('#plan-table').DataTable().ajax.reload();
        }
    });

});

});
</script>
@endpush