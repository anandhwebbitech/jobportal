$(function () {

    const dialogs = {
        message: document.getElementById('messageDialog'),
        delete: document.getElementById('deleteDialog')
    };

    let deleteRoute = null;
    let tableId = null;

    /* ================= MESSAGE DIALOG ================= */

    $(document).on('click', '.viewMessage', function () {
        $('#fullMessage').text($(this).data('message'));
        dialogs.message.showModal();
    });

    dialogs.message.addEventListener('click', e => {
        if (!isInside(dialogs.message, e)) dialogs.message.close();
    });

    /* ================= DELETE DIALOG ================= */

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();
        deleteRoute = $(this).data('route');
        tableId = $(this).data('table-id');
        if (!deleteRoute) return console.error('Delete route missing');
        dialogs.delete.showModal();
    });

    $(document).on('click', '#confirmDelete', function () {
        if (!deleteRoute) return;

        $.ajax({
            url: deleteRoute,
            type: 'DELETE',
            data: { _token: csrf() },
            success: function(response) {
                toastr.success('Data deleted successfully');
                closeDelete();
                if (tableId) {
                   let table = $('#' + tableId).DataTable();
                    table.ajax.reload(null, false); 
                }
            },
            error: function(err) {
                toastr.error('Data Delete failed');
            }
        });
    });

    $('#cancelDelete, #cancelDeleteFooter').on('click', closeDelete);

    /* ================= HELPERS ================= */

    function isInside(dialog, e) {
        const r = dialog.getBoundingClientRect();
        return e.clientX >= r.left && e.clientX <= r.right &&
               e.clientY >= r.top  && e.clientY <= r.bottom;
    }

    function closeDelete() {
        dialogs.delete.close();
        deleteRoute = null;
    }

    function csrf() {
        return $('meta[name="csrf-token"]').attr('content');
    }

    $(document).on('click', '.common_model', function () {
        const model_title = $(this).data('title');
        const model_route = $(this).data('route');
        const model_size = $(this).data('size');

        $('#model-title').text(model_title);
        $('#model-body').html(`
            <div class="text-center py-4">
                <span class="spinner-border"></span>
            </div>
        `);

        $.ajax({
            url: model_route,
            type: 'GET',
            success: function (response) {
                $('.modal-dialog').addClass(model_size);
                $('#model-body').html(response.html);
                $('#form-model').modal('show');
            },
            error: function () {
                toastr.error('Failed to load form');
            }
        });
    });

    $(document).on('click', '.closeModal', function () {
        document.getElementById('form-model').close();
    });

});
