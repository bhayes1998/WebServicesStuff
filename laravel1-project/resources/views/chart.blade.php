<x-main-layout>
<x-slot name="title">
  Lambda Assignment 
</x-slot>
<x-slot name="SCRIPT">lambda.js</x-slot>
<div class="content">
<div id="msg"></div>
Enter date query: <input type="input" id="date" value="1963-01-05">
<span class="btn btn-info" id="query">querty</span>
<br>
<table class="table" id="chart info">
<tbody><tr><td>Date</td><td>Rank</td><td>Song</td><td>like</td></tr>
</tbody><tbody id="chart-data"></tbody>
</table>

</x-main-layout>
