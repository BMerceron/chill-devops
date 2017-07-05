$( document ).ready(function() {
    var data = $("#chartDatas").val();

    console.log(data);

    var dataset = JSON.parse(data);

    console.log(dataset);

    var regions = [];
    var nbData = dataset.length;
    var PByMonth = nbData/5;
    //year1
    var year = {axis:'x',start:0, end: PByMonth, class:"regionYear"};
    regions.push(year);
    //year3
    year = {axis:'x', start:PByMonth*2, end:PByMonth*3, class:"regionYear"};
    regions.push(year);
    //year5
    year = {axis:'x', start: nbData-PByMonth, class:"regionYear"};
    regions.push(year);
    

  var indusChart = c3.generate({
  bindto: "#chart-container-industrial",
  data:{
        json: dataset,
        keys: {
            x : 'LastMonth',
            value: ['Clients', 'PriceByMonth', 'BuyingCost'],
        },
        types: {
            BuyingCost: 'bar'
        },
        axes: {
            Clients: 'y',
            BuyingCost: 'y2'
        },
      colors: {
          BuyingCost: 'blue',
          Clients: 'red',
          PriceByMonth: 'orange'
        }
    },
    bar: {
        width: {
            ratio: 0.5 }
    },
    axis: {
        x: {
            type: 'category',
            label: {
                text: 'Durée ( périodicité )',
                position: 'outer-center'
            }
        },
        y: {
            label: {
                text: 'Clients',
                position: 'outer-middle'
            }
        },
        y2: {
            label: {
                text: 'Achats Matériel',
                position: 'outer-middle'
            },
            tick: {
                format: function (d) { 
                    return (d + " €"); 
                }
            },
            show: true
        }
    },
    tooltip: {
        format: {
            title: function (d) { return d; },
            value: function (value, ratio, id) {
                var res = value;
                if(id !== "Clients" ){
                    res = value + " €";
                }
                return res;
            }
        }
    },
    zoom: {
        enabled: true
    },
    regions: regions
  });

  //Création du 2eme label Y
  var indusClientLabel = $("#chart-container-industrial .c3-axis-y-label");
  var x = indusClientLabel.attr("x");
  var dx = indusClientLabel.attr("dx");
  var y = indusClientLabel.attr("y");
  var dy = indusClientLabel.attr("dy");

  var yIndusLabel = d3.select("#chart-container-industrial svg>g");
  yIndusLabel.append("text")
    .attr("class", "axis-y-2-indus")
    .attr("transform", "rotate(-90)")
    .attr("x", x)
    .attr("dx", dx)
    .attr("y", y)
    .attr("dy", dy)
    .text("Frais de maintenance")
    .style("text-anchor", "middle")
    .style("opacity",0);

var greenChart = c3.generate({
  bindto: "#chart-container-green",
  data:{
        json: dataset,
        keys: {
            x : 'LastMonth',
            value: ['Clients', 'GreenPriceByMonth', 'GreenBuyingCost'],
        },
        types: {
            GreenBuyingCost: 'bar'
        },
        axes: {
            Clients: 'y',
            GreenBuyingCost: 'y2'
        },
      colors: {
          GreenBuyingCost: 'blue',
          Clients: 'red',
          GreenPriceByMonth: 'green'
        }
    },
    bar: {
        width: {
            ratio: 0.5 }
    },
    axis: {
        x: {
            type: 'category',
            label: {
                text: 'Durée ( périodicité )',
                position: 'outer-center'
            }
        },
        y: {
            label: {
                text: 'Clients',
                position: 'outer-middle'
            }
        },
        y2: {
            label: {
                text: 'Achats Matériel',
                position: 'outer-middle'
            },
            tick: {
                format: function (d) { 
                    return (d + " €"); 
                }
            },
            show: true
        }
    },
    tooltip: {
        format: {
            title: function (d) { return d; },
            value: function (value, ratio, id) {
                var res = value;
                if(id !== "Clients" ){
                    res = value + " €";
                }
                return res;
            }
        }
    },
    zoom: {
        enabled: true
    },
    regions: regions
  });

  //Création du 2eme label Y
  var greenClientLabel = $("#chart-container-green .c3-axis-y-label");
  x = greenClientLabel.attr("x");
  dx = greenClientLabel.attr("dx");
  y = greenClientLabel.attr("y");
  dy = greenClientLabel.attr("dy");

  var yGreenLabel = d3.select("#chart-container-green svg>g");

  yGreenLabel.append("text")
    .attr("class", "axis-y-2-green")
    .attr("transform", "rotate(-90)")
    .attr("x", x)
    .attr("dx", dx)
    .attr("y", y)
    .attr("dy", dy)
    .text("Frais de maintenance")
    .style("text-anchor", "middle")
    .style("opacity",0);

  var indusToggle = true;
  var indusChartContainer = $("#chart-container-industrial");
  indusChartContainer.find(".c3-legend-item-Clients").click(function(){
      if(indusToggle){
        indusChartContainer.find(".c3-axis-y-label").hide();
        indusToggle = false;
        $(".axis-y-2-indus").css("opacity", 1);
      }
      else{
        indusChartContainer.find(".c3-axis-y-label").show();
        indusToggle = true;
        $(".axis-y-2-indus").css("opacity", 0);
      }
  });

  var greenToggle = true;
  var greenChartContainer = $("#chart-container-green");
  greenChartContainer.find(".c3-axis-item-Clients").click(function(){
    if(greenToggle){
        greenChartContainer.find(".c3-axis-y-label").hide();
        greenToggle = false;
        $(".axis-y-2-green").css("opacity", 1);
    }
    else{
        greenChartContainer.find(".c3-axis-y-label").show();
        greenToggle = true;
        $(".axis-y-2-green").css("opacity", 0);
    }
  });

});