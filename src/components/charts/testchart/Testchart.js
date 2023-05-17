import React from 'react';
import { render } from 'react-dom';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import { Grid } from '@mui/material';


const options = {
  chart: {
    type: 'spline',
    zoomType: 'x'
  },
  title: {
    text: 'Example Spline Chart'
  },
  xAxis: {
    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
  },
  yAxis: {
    title: {
      text: 'Value'
    }
  },
  series: [{
    name: 'Series 1',
    data: [1, 3, 2, 4, 5, 6, 8, 7, 9, 10, 11, 12]
  }, {
    name: 'Series 2',
    data: [5, 7, 6, 8, 9, 10, 12, 11, 13, 14, 15, 16]
  
}],
  legend: {
    layout: 'vertical',
    align: 'right',
    verticalAlign: 'middle'
  },
  plotOptions: {
    spline: {
      marker: {
        enabled: true
      }
    }
  },
  // Adding the buttons

};

function Testchart() {
  return (
    <Grid container>
      <Grid item xs={12} md={6}>
      <HighchartsReact highcharts={Highcharts} options={options} /> 
      </Grid>
      {/* <Grid item xs={12} md={3.65}>
        <HighchartsReact highcharts={Highcharts} options={getOptions('line')} />
      </Grid>
      <Grid item xs={12} md={6}>
        <HighchartsReact highcharts={Highcharts} options={getOptions('spline')} />
      </Grid>
      <Grid item xs={12} md={6}>
        <HighchartsReact highcharts={Highcharts} options={getOptions('areaspline')} />
      </Grid>
      <Grid item xs={12} md={6}>
        <HighchartsReact highcharts={Highcharts} options={getOptions('column')} />
      </Grid>
      <Grid item xs={12} md={6}>
        <HighchartsReact highcharts={Highcharts} options={getOptions('bar')} />
      </Grid>
      <Grid item xs={12} md={6}>
        <HighchartsReact highcharts={Highcharts} options={getOptions('pie')} />
      </Grid>
      <Grid item xs={12} md={6}>
        <HighchartsReact highcharts={Highcharts} options={getOptions('scatter')} />
      </Grid> */}
    </Grid>
  );
}

export default Testchart;








// import { useEffect, useState } from 'react';

// // material-ui
// import { useTheme } from '@mui/material/styles';

// // third-party
// import ReactApexChart from 'react-apexcharts';

// // chart options
// const barChartOptions = {
//     chart: {
//         type: 'bar',
//         height: 365,
//         toolbar: {
//             show: false
//         }
//     },
//     plotOptions: {
//         bar: {
//             columnWidth: '45%',
//             borderRadius: 4
//         }
//     },
//     dataLabels: {
//         enabled: false
//     },
//     xaxis: {
//         categories: ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'],
//         axisBorder: {
//             show: false
//         },
//         axisTicks: {
//             show: false
//         }
//     },
//     yaxis: {
//         show: false
//     },
//     grid: {
//         show: false
//     }
// };

// // ==============================|| MONTHLY BAR CHART ||============================== //

// const Testchart = () => {
//     const theme = useTheme();

//     const { primary, secondary } = theme.palette.text;
//     const info = theme.palette.info.light;

//     const [series] = useState([
//         {
//             data: [80, 95, 70, 42, 65, 55, 78]
//         }
//     ]);

//     const [options, setOptions] = useState(barChartOptions);

//     useEffect(() => {
//         setOptions((prevState) => ({
//             ...prevState,
//             colors: [info],
//             xaxis: {
//                 labels: {
//                     style: {
//                         colors: [secondary, secondary, secondary, secondary, secondary, secondary, secondary]
//                     }
//                 }
//             },
//             tooltip: {
//                 theme: 'light'
//             }
//         }));
//         // eslint-disable-next-line react-hooks/exhaustive-deps
//     }, [primary, info, secondary]);

//     return (
//         <div id="chart">
//             <ReactApexChart options={options} series={series} type="bar" height={365} />
//         </div>
//     );
// };

// export default Testchart;