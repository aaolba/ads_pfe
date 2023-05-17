import { Grid } from '@mui/material';
import Campaigns_table from '../components/campaigns_table/Campaigns_table';
import { useEffect, useState } from 'react';
import axios from 'axios';
import DatePicker from '../components/dateRangePicker/DateRangePicker';
import Paginations from '../components/pagination/Pagination';
import Status_select from '../components/select/Status_select';
import Navbar from '../layouts/navbar/Navbar'
import { useParams } from 'react-router-dom';



const Campagns = () => {
const {page_name}=useParams()
  const [status, setstatus] = useState('');
  const [dateRange, setDateRange] = useState(["", ""]);
  const [startDate, endDate] = dateRange;

  const [campaigns, setcampaigns] = useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const recordsPerPage = 16;
  const [postsNumber, setpostsNumber] = useState(null);
  console.log(status);
  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/allCampaigns', {
      params: {
        start: startDate,
        end: endDate,
        currentPage: currentPage,
        status: status,
        page_name:page_name,
      }
    })
      .then(Response => {
        setcampaigns(Object.values(Response.data[0]));
        setpostsNumber(Response.data[1]);

      })
      .catch(error => {
        console.log(error);
      })
  }, [startDate, endDate, currentPage, status]);

  const nPages = Math.ceil(postsNumber / recordsPerPage);

  return (


      <Grid container spacing={2}>
        <Grid item md={2.8} paddingTop={10}>
          {/* <Sidebar /> */}
        </Grid>
        <Grid item md={9} >
        <Grid container justifyContent="flex-start" padding={2} item>
        <h1>Campaigns List</h1>
        </Grid>
          <Grid container paddingTop={2} justifyContent="flex-end" paddingBottom={3}>
            <Grid paddingRight={2}>
              <Status_select setstatus={setstatus} setCurrentPage={setCurrentPage} />
            </Grid>
            <Grid>
              <DatePicker setDateRange={setDateRange} setCurrentPage={setCurrentPage} />
            </Grid>
          </Grid>
          <Campaigns_table campaigns={campaigns} />
          <Paginations nPages={nPages} setpage={setCurrentPage} page={currentPage} />
        </Grid>
      </Grid>
  )
}

export default Campagns;