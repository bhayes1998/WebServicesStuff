/*
Bryan Hayes
CSE 451
2/8/2021 
Assignment Wednesday Week2
*/
$(document).ready(function() {
  $.ajax({
    url: "http://ceclnx01.cec.miamioh.edu/~hayesbm3/cse451-hayesbm3-web/week2/week2-rest.php/api/v1/info",
    success: function(data) {
      var tab = `<tbody><tr> 
          <th>Key</th> 
          <th>Value</th>  
          </tr>`; 
      for (i in data.keys){
        tab += `<tr>  
          <td>${i} </td> 
          <td>${data.keys[i]}</td>            
          </tr>`;
      }
      $('#datatable').append(tab);
    },
    error: function() {
      $('#datatable').append("No data could be found");
    }
  });
});