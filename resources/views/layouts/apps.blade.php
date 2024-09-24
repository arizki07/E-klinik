<!DOCTYPE html>
<html lang="en-US" dir="ltr">

@include('shared.head')

<body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
        <div class="container" data-layout="container">
            <script>
                var isFluid = JSON.parse(localStorage.getItem('isFluid'));
                if (isFluid) {
                    var container = document.querySelector('[data-layout]');
                    container.classList.remove('container');
                    container.classList.add('container-fluid');
                }
            </script>
            @include('shared.script')

            @include('shared.sidebar')
            <div class="content">
                @include('shared.navbar')
                @yield('content')
                @include('shared.footer')
            </div>

        </div>
    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->


    @include('shared.costomize')


    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->

</body>

</html>
