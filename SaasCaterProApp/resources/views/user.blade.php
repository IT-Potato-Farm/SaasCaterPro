@extends ('layouts.default')

@section('title')
    SaasCaterPro User
@endsection

@section ('body')

    <header>
        <h3>SaasCaterPro USER</h3>
    </header>

        <div>
            <a href="/login">Go Login</a>
            <a href="/register">Go Signup</a>
        </div>



    @if (session('success'))
        <!-- <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success')}}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#f0fdfa',
                iconColor: '#06b6d4',
                color: '#164e63',
                timerProgressBar: true,
                showClass: {
                    popup: 'swal2-show animate-slide-in'
                },
                hideClass: {
                    popup: 'swal2-hide animate-slide-out'
                }
            });
        </script> -->
    @endif

@endsection