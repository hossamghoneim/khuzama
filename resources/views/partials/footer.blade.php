<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                © {{ \Carbon\Carbon::now()->year - 1 }} - {{ \Carbon\Carbon::now()->year }} | {{ config('app.name') }}
            </div>
        </div>
    </div>
</footer>



<!-- jQuery  -->
{{ Html::script('assets/js/jquery.min.js') }}
{{ Html::script('assets/js/popper.min.js') }}<!-- Popper for Bootstrap -->
{{ Html::script('assets/js/bootstrap.min.js') }}
{{ Html::script('assets/js/waves.js') }}
{{ Html::script('assets/js/jquery.slimscroll.js') }}
{{ Html::script('assets/js/jquery.scrollTo.min.js') }}

@yield('scripts')

<!-- App js -->
{{ Html::script('assets/js/jquery.core.js') }}
{{ Html::script('assets/js/jquery.app.js') }}

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>