import {useState,useEffect} from 'react';
import Highcharts from 'highcharts';
import HighchartsReact from 'highcharts-react-official';
import { Grid } from '@mui/material';
import { Button, Space } from 'antd';
import { useParams } from 'react-router-dom';
import axios from 'axios';


const Areachart = () => {

  const {post_id} = useParams()
  const [filter, setfilter] = useState("day")
  const [values, setvalues] = useState([])
  const [time, settime] = useState([])
console.log(filter);


useEffect(() => {
  axios.get('http://127.0.0.1:8000/api/clickstat', {
    params: {
      post_id:post_id,
      filter:filter,
    }
  })
    .then(Response => {
      setvalues(Object.values(Response.data[0]));
      settime(Response.data[1]);
      consoel.log(values)
      consoel.log(time)
    })
    .catch(error => {
      console.log(error);
    })
}, [filter]);
    const options = {
        chart: {
            borderWidth: 2,
            borderColor: '#E6EBF1',
            type: 'area',
            width: 1362,
            name:"",
            zoomType: 'x',
            borderRadius: 3,
           
            
        },
        credits: {
            enabled: false
         },
        title: {
          text: 'Croissance des clicks ',
          
        },
        xAxis: {
          categories: time ,
          labels: {
            rotation: -70,
            align: 'right'
          }
        },
        yAxis: {
          title: {
            text: 'Value'
          }
        },
        series: [{
          name: 'orange',
          data: values ,
          // marker: {
          //   enabled: false
          // }
        // }, {
        //   name: 'Series 2',
        //   data: [5, 7, 6, 8, 9, 10, 12, 11, 13, 14, 15, 16]
        // 
      }],
       
      
    };

  return (
    <div style={{width: 1362}}>
      <Grid item container xs={12} md={12} justifyContent="flex-end"  paddingTop={2} paddingBottom={2} >
                <Space wrap>
                  <Button onClick={() => { setfilter('day') }} type="primary">Day</Button>
                  <Button onClick={() => { setfilter('month') }} >Month</Button>
                </Space>
              </Grid>
      <HighchartsReact highcharts={Highcharts} options={options} />
    </div>

  )
}

export default Areachart