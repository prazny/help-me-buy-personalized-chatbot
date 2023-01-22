<style>
    :root {
        @foreach($variables as $key => $variable)
            @if(!empty($variable))
                --{{$key}}:{{$variable}};
            @endif
        @endforeach
    }
</style>
