@extends ('layouts.default')

@section ('title')
    SaasCaterPro Login
@endsection

@section ('body')

    <section>
        <div>
            {{-- Error Validation --}}
            @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Success Mesage --}}
            @if (session('success'))
                <div>
                    {{ session('success') }}
                </div>
            @endif

                <form id="loginForm" action="{{ url('/loginapi') }}" method="POST" novalidate>
                    @csrf
                    <div>
                        <input type="email" name="loginemail" id="loginemail" placeholder="Email Address">
                    </div>

                    <div>
                        <input type="password" name="loginpassword" id="loginpassword" placeholder="Password">
                        <button type="button" onclick="togglePassword()">Show</button>
                    </div>

                    <button type="submit">
                        Login
                    </button>
                </form>

                <span class="">Dont have an account? <a href="/register" class="hover:underline">Register here</a></span>
        </div>
    </section>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("loginpassword");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                } else {
                passwordField.type = "password";
            }
        }
    </script>

@endsection