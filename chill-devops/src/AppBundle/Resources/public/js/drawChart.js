$( document ).ready(function() {
    var data = $("#chartDatas").val();

    var dataset = JSON.parse(data);

  var chart = c3.generate({
  bindto: "#chart-container",
  data:{
        json: dataset,
        keys: {
            value: ['Client', 'PriceByMonth', 'BuyingCost', 'GreenPriceByMonth', 'GreenBuyingCost'],
        },
        types: {
            BuyingCost: 'bar',
            GreenBuyingCost: 'bar',
        },
        axes: {
            Client: 'y',
            BuyingCost: 'y2',
            GreenBuyingCost: 'y2'
        },
      colors: {
          GreenPriceByMonth: 'green',
          GreenBuyingCost: 'blue',
          BuyingCost: 'purple',
          Client: 'red',
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
                text: 'Durée',
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
            show: true
        }
    }
  });

});

