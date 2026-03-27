<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

<link href="{{ asset('admin/common_css.css')}}" rel="stylesheet">
<link rel="stylesheet"href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<style>
    /* Base submenu (hidden state) */
    .submenu {
        max-height: 0;
        overflow: hidden;
        opacity: 0;
        transform: translateY(-5px);
        padding-left: 15px;
        transition: 
            max-height 0.35s ease,
            opacity 0.25s ease,
            transform 0.25s ease;
    }

    /* Smooth open animation */
    .submenu.open {
        max-height: 500px; 
        opacity: 1;
        transform: translateY(0);
    }

    /* Arrow smooth rotate */
    .has-submenu .submenu-arrow {
        transition: transform 0.3s ease;
    }

    .has-submenu.open .submenu-arrow {
        transform: rotate(180deg);
    }
    .dataTables_filter{
        margin-bottom: 10px !important;
    }
    .table>:not(caption)>*>* {
        background-color: #ccebcf !important;
    }
    .ck-powered-by{
        display: none !important;
    }
  </style>
