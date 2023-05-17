// import React, { useState } from 'react'

// import { LocalizationProvider } from '@mui/x-date-pickers-pro';
// import { AdapterDayjs } from '@mui/x-date-pickers-pro/AdapterDayjs';
// import { DateRangePicker } from '@mui/x-date-pickers-pro';
// import { Grid } from '@mui/material';
// const DatePicker = () => {
//   const [daterange,setdaterange]=useState(null,null);
//   console.log(daterange);
//     return (
//     <Grid width={600} >
//         <LocalizationProvider  dateAdapter={AdapterDayjs}>
//             <DateRangePicker   localeText={{ start: 'from', end: 'to' }} onChange={(newValue)=>setdaterange(newValue)}/>
//         </LocalizationProvider>
//     </Grid>
//   )
// }

// export default DatePicker



import React, { useState } from 'react'
import { DatePicker, Space } from 'antd';
const { RangePicker } = DatePicker;
const DateRangePicker = (props) => {


  
  
  function formatDate(d){
    if(d===""){
      return ""
    }else{
      const date = new Date(d);
      const year = date.getFullYear();
      const month = ('0' + (date.getMonth() + 1)).slice(-2);
      const day = ('0' + date.getDate()).slice(-2);
      return  `${year}-${month}-${day}`;
    }
  }
  
console.log()




  return(
  <Space direction="vertical" size={12}>
     <RangePicker
     defaultValue=''
      onChange={(update) => {
        props.setCurrentPage(1);
        if(update===null){
          props.setDateRange(["",""]);
          
        }else{
          props.setDateRange([formatDate(update[0]),formatDate(update[1])]);

        }
      }}
      
      />
  </Space>
)
};
export default DateRangePicker;