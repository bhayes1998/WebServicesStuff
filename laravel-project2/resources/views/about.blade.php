<x-main-layout>
<x-slot name="pageTitle">
Bryan Hayes
</x-slot>

<div class="row">
<div class="col-md-8 offset-md-2 mx-auto text-center">

<div style="margin-bottom: 12px">
<h2>Name</h2>{!! $name !!}
</div>

<h2>Loop from code</h2>
Random Numbers
<br>
@foreach ($data as $d)
<div>{{$d}}</div>
@endforeach

</div>
</div>
</x-main-layout>
