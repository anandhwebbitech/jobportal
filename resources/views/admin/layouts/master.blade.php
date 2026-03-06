<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ setting('site_name') }}</title>
    @include('admin.layouts.css_master')

        <style>
        /* Perfect center dialog */
        dialog {
            border: none;
            padding: 0;
            width: 350px;
            border-radius: .5rem;
            opacity: 0;
            transform: scale(0.8);
            transition: all .25s ease;
            /* position: fixed; */
            top: 50%;
            left: 50%;        
        }

        /* When opened */
        dialog[open] {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        /* Dark backdrop */
        dialog::backdrop {
            background: rgba(0, 0, 0, 0.3);
            animation: fadeIn .25s ease;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <style>
        /* Match input fields with glossy panel theme */
        .gloss .form-control,
        .gloss .form-select {
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(0, 150, 100, 0.15);
            border-radius: 12px;
            padding: 10px 14px;
            font-size: 14px;
            color: #1b3c36;
            backdrop-filter: blur(6px);
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.04);
            transition: all 0.25s ease;
        }

        /* Focus effect like panel glow */
        .gloss .form-control:focus,
        .gloss .form-select:focus,
        .gloss textarea:focus {
            background: #ffffff;
            border-color: #1fbf8f;
            box-shadow: 0 0 0 3px rgba(31, 191, 143, 0.15);
            outline: none;
        }

        /* File input styling */
        .gloss input[type="file"] {
            background: rgba(255, 255, 255, 0.75);
            border: 1px dashed rgba(0, 150, 100, 0.25);
            border-radius: 12px;
            padding: 8px 12px;
            cursor: pointer;
        }

        /* Placeholder styling */
        .gloss .form-control::placeholder,
        .gloss textarea::placeholder {
            color: #7aa9a1;
            font-weight: 400;
        }

        /* Label styling to match UI */
        .gloss .form-label {
            color: #2f5d56;
            font-weight: 600;
            margin-bottom: 6px;
        }
    </style>
</head>

<body>
    @include('admin.layouts.sidebar')

    @include('admin.layouts.header')

    <!-- ── Main Content ── -->
    @yield('content')

    <!-- Delete Confirmation Dialog -->
    <dialog id="deleteDialog" class="p-0 border-0">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                <span id="delete-title">Delete</span>
                <button type="button" class="btn-close btn-close-white" id="cancelDelete"></button>
            </div>
            <div class="card-body">
                <p class="mb-0">Are you sure you want to delete this data?</p>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2 bg-light">
                <button id="cancelDeleteFooter" class="btn btn-sm btn-secondary">Cancel</button>
                <button id="confirmDelete" class="btn btn-sm btn-danger">Delete</button>
            </div>
        </div>
    </dialog>

    <dialog id="messageDialog" class="p-0 border-0 messageDialog">
        <div class="card shadow-sm modal-lg">
            <div class="card-body" id="fullMessage">
                <!-- Message loads here -->
            </div>
        </div>
    </dialog>

    <!-- Modal -->
    <div class="modal fade" id="form-model" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="model-title"></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div id="model-body">
                    
                </div>
            </div>
        </div>
    </div>

    @include('admin.layouts.js_master')
    @stack('scripts')

</body>

</html>
