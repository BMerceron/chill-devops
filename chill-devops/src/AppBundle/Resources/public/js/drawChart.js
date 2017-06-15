$( document ).ready(function() {
    var data = $("#chartDatas").val();

    var dataset = JSON.parse(data);
    console.log(dataset);

    var dataTEST = [{Client:5000,PriceByMonth:20,BuyingCost:850,LastMonth:12},
                    {Client:5500,PriceByMonth:20,BuyingCost:0,LastMonth:24},
                    {Client:6050,PriceByMonth:20,BuyingCost:0,LastMonth:36},
                    {Client:6655,PriceByMonth:50,BuyingCost:1200,LastMonth:48},
                    {Client:7321,PriceByMonth:100,BuyingCost:0,LastMonth:60}];


  var chart = c3.generate({
  bindto: "#chart-container",
  data:/*{
    json: data,
    keys: {
      value: ['Client', 'PriceByMonth'],
        }
    }*/{
            json: dataset,
            keys: {
//                x: 'name', // it's possible to specify 'x' when category axis
                value: ['Client', 'PriceByMonth'],
            }
        },
  });

});

