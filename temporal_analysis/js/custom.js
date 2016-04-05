google.load("visualization", "1", {packages:["corechart"]});
google.load("visualization", "1", {packages:["table"]}); 

$(document).ready(function () {
    $(".box-content").on('mouseenter', function () {
        $(".chart_div").show();
    });
     $(".box-content").on('mouseleave',  function () {
        $(".chart_div").hide();
    });
    $('.manufacturer_list li').click(function() {
    var manufacturer = $(this).text();
    $('.manufacturer_list li').css("background","#fff");
    $(this).css("background","#7f7f7f");
    $.ajax({
            url: 'ajax_manufacturer.php',
            type: 'POST',
            data: {manufacturer:manufacturer},
            success:function(data){

                $('.product_details').html(data);
            }
        });
    });

    $('#product_search').keyup(function() {
    var search = $(this).val();
    $.ajax({
            url: 'ajax_search.php',
            type: 'POST',
            data: {search:search},
            success:function(data){

                $('.product_details').html(data);
            }
        });
    });
   
$('.manufacturer_list li').mouseover(function() {
    var manufacturer = $(this).text();
    $(this).css("color","#02baff");
    if(manufacturer!="ALL"){
      $("#chart_area").show();
      $.ajax({
              url: 'ajax_graph.php',
              type: 'POST',
              data: {manufacturer:manufacturer},
              success:function(data){ 
                  var data = JSON.parse(data);
                  data.sort(function(a,b){
                    return -a.time_period.localeCompare(b.time_period);
                  });
                  var Combined = new Array();
                  Combined[0] = ['Time Period', 'Avg. Review Rating', { role: 'annotation' } ];
                  for (var i = 0; i < 12; i++){
                      Combined[i + 1] = [ data[i].time_period,data[i].rating,data[i].count];
                  }
                  var data = google.visualization.arrayToDataTable(Combined, false);
                  var options = {
                    title: manufacturer+' Rating vs Review Count',
                    //'width':screen.width*.95,
                    //'height':screen.height*.8,
                     backgroundColor: {
                        'fill': '#E7E7E7',
                        'opacity': 100
                     },
                    annotations:{alwaysOutside:true},
                    
                    chartArea: {width: '40%'}
                  };
                  var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                  chart.draw(data, options);
              }
          });
        }
    });
    $('.manufacturer_list li').mouseout(function() {
      $(this).css("color","#000");
    });
    $('#close_graph').click(function() {

         $("#chart_area").hide();
       });
    
});
