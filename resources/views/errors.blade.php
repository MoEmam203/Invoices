@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session()->has('add'))
    <script>
        window.onload = function() {
            notif({
                msg:"{{ session()->get('add') }}",
                type: "success"
            })
        }
    </script>
@endif

@if (session()->has('delete'))
    <script>
        window.onload = function() {
            notif({
                msg:"{{ session()->get('delete') }}",
                type: "error"
            })
        }
    </script>
@endif

@if (session()->has('edit'))
    <script>
        window.onload = function() {
            notif({
                msg:"{{ session()->get('edit') }}",
                type: "info"
            })
        }
    </script>
@endif