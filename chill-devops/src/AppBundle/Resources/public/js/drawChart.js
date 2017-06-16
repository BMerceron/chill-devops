$( document ).ready(function() {
    var data = $("#chartDatas").val();

    var dataset = JSON.parse(data);

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
    

  var chart = c3.generate({
  bindto: "#chart-container",
  data:{
        json: dataset,
        keys: {
            value: ['Clients', 'PriceByMonth', 'BuyingCost', 'GreenPriceByMonth', 'GreenBuyingCost'],
        },
        types: {
            BuyingCost: 'bar',
            GreenBuyingCost: 'bar',
        },
        axes: {
            Clients: 'y',
            BuyingCost: 'y2',
            GreenBuyingCost: 'y2'
        },
      colors: {
          GreenPriceByMonth: 'green',
          GreenBuyingCost: 'blue',
          BuyingCost: 'purple',
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

});

