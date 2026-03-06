<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin/js/custom-script.js') }}"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    const sidebar = document.getElementById('sidebar');
    const header = document.getElementById('header');
    const main = document.getElementById('main');
    const SIDEBAR_W = '270px';
    let isOpen = true;

    function toggleSidebar() {
        const mobile = window.innerWidth <= 992;

        if (mobile) {
            sidebar.classList.toggle('open');
        } else {
            isOpen = !isOpen;
            if (isOpen) {
                sidebar.classList.remove('closed');
                header.style.left = SIDEBAR_W;
                main.style.marginLeft = SIDEBAR_W;
            } else {
                sidebar.classList.add('closed');
                header.style.left = '0';
                main.style.marginLeft = '0';
            }
        }
    }

    window.addEventListener('resize', () => {
        if (window.innerWidth > 992) {
            sidebar.classList.remove('open');
            if (isOpen) {
                sidebar.classList.remove('closed');
                header.style.left = SIDEBAR_W;
                main.style.marginLeft = SIDEBAR_W;
            }
        } else {
            header.style.left = '';
            main.style.marginLeft = '';
        }
    });

    // Toggle submenu
    function toggleSubmenu(el) {
        const isOpen = el.classList.contains('open');
        document.querySelectorAll('.has-submenu.open').forEach(item => {
        item.classList.remove('open');
        const sub = item.nextElementSibling;
        if (sub && sub.classList.contains('submenu')) sub.classList.remove('open');
        });
        if (!isOpen) {
        el.classList.add('open');
        const sub = el.nextElementSibling;
        if (sub && sub.classList.contains('submenu')) sub.classList.add('open');
        }
    }

    // Active nav link
    function setActive(el) {
        document.querySelectorAll('.sidebar a').forEach(a => a.classList.remove('active'));
        el.classList.add('active');
    }

    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
