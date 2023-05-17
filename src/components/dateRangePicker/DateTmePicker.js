import  {useState} from 'react';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import { LocalizationProvider } from '@mui/x-date-pickers/LocalizationProvider';
import { StaticDateTimePicker } from '@mui/x-date-pickers/StaticDateTimePicker';
import './dateTimePicker.css'

const  DateTimePicker = (props)=> {

  return (
    <LocalizationProvider dateAdapter={AdapterDayjs}>
      <StaticDateTimePicker orientation="landscape" 
      className='test'
      onAccept={(update) => {
        const date=new Date(update)
        const unix=date.getTime()/1000
        props.setPlaningTime(unix)
      }}
      disablePast='true'
      />
    </LocalizationProvider>
  );
}
export default DateTimePicker;