<script>
    window.location.href = "{{ route('home') }}";
</script>

{{-- Or if you prefer a more elegant redirect: --}}
@php
    redirect()->route('home')->send();
@endphp