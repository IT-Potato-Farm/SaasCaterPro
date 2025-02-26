@extends ('layouts.default')

@section ('title')
    SaasCaterPro Register
@endsection 

@section ('body')
    <section>
        <div>
            <div>
                <div>

                    <div>
                        <h1>
                            Registration
                        </h1>
                    </div>

                    <h1>
                        Create an account
                    </h1>

                        {{-- Error Validation Message --}}

                        @if ($errors->any())
                            <div>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Success Message --}}
                        @if (session('success'))
                            <div>
                                {{ session('success') }}
                            </div>
                        @endif


                        <form action="{{ url('/registerapi') }}" method="POST">
                            @csrf

                            <div>
                                <label for="first_name">First Name:</label>
                                <input type="text" name="first_name" id="first_name">
                            </div>

                            <div>
                                <label for="last_name">Last Name:</label>
                                <input type="text" name="last_name" id="last_name">
                            </div>
                            
                            <div>
                                <label for="mobile">Mobile Number:</label>
                                <input type="tel" name="mobile" id="mobile" placeholder="enter your mobile number">
                            <div>

                            <div>
                                <label for="email">Email Address:</label>
                                <input type="email" name="email" id="email" placeholder="name@company.com">
                            </div>

                            <div>
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password" placeholder="enter your password">
                                <button type="button" onclick="togglePassword()">Show</button>
                            </div>

                            <div>
                                <label for="confirm-password">Confirm password:</label>
                                <input type="password" name="password_confirmation" id="confirm-password" placeholder="confirm your password"  required>
                                <button type="button" onclick="toggleConfirmPassword()">Show</button>
                            </div>

                            <div>
                            <div>
                                <input id="terms" aria-describedby="terms" type="checkbox">
                            </div>
                                <div>
                                    <label for="terms">I accept the <a>Terms and Conditions</a></label>
                                </div>
                            </div>

                        <button type="submit">Create an account</button>
                        <p>Already have an account? <a href="/login">Login here</a></p>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        function togglePassword() {
            let passwordField = document.getElementById("password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                } else {
                passwordField.type = "password";
            }
        }

        function toggleConfirmPassword() {
            let passwordField = document.getElementById("confirm-password");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                } else {
                passwordField.type = "password";
            }
        }
    </script>
    
@endsection