import React ,{useEffect, useState} from 'react'
import { Grid } from '@mui/material';
import { useLoaderData, useParams,Link } from 'react-router-dom';
import axios from 'axios';

import './postlibrary.css';
import Post from '../components/Post/Post';
import Paginations from '../components/pagination/Pagination';
import DatePicker from '../components/dateRangePicker/DateRangePicker';
import Navbar from '../layouts/navbar/Navbar'



export default function Campagns_posts(){

    const {campagn_id} = useParams();
    // const campaign_posts= useLoaderData();
    // console.log(campaign_posts);






    const [dateRange, setDateRange] = useState(["",""]);
    const [startDate, endDate] = dateRange;

    const [Posts,setPosts]=useState([]);
    const [currentPage, setCurrentPage] = useState(1);
    const recordsPerPage =16;
    const [postsNumber,setpostsNumber]=useState(null);



    useEffect(()=>{
        axios.get('http://127.0.0.1:8000/api/post_campaign',{
          params:{
            campaign_id : campagn_id,
            start : startDate,
            end : endDate,
            currentPage:currentPage,
  
          }
        })
        .then(Response =>{
          setPosts(Object.values(Response.data[0]));
          setpostsNumber(Response.data[1]);
        })
        .catch(error =>{
          console.log(error);
        })
      },[startDate,endDate,currentPage]);

    const nPages=Math.ceil(postsNumber/recordsPerPage);


  return (

  <Grid container spacing={2}>
    <Grid item md={2.8} paddingTop={10}>
      {/* <Sidebar /> */}
    </Grid>
    <Grid item md={9}>
   
    <div>
        <Grid container justifyContent="flex-end" padding={2} paddingTop={7} item>
          <Grid paddingRight={2}>
            {/* <Input placeholder="page name" /> */}
            {/* <Platforme_select setCurrentPage={setCurrentPage} setPlatforme={setPlatforme} /> */}
          </Grid>
          <Grid>
            <DatePicker setDateRange={setDateRange} setCurrentPage={setCurrentPage}/>
          </Grid>
        </Grid>
        <Grid container spacing={4} padding={2}>
          {Posts.map(post => (
            <Grid item xs={6} md={3} sm={6} key={post.ad_id}> 
              <Link className='test_link' to={`${post.ad_id}`}>
                <Post data={post} />
              </Link>
            </Grid>
          ))}
        </Grid>
        <Paginations nPages={nPages} setpage={setCurrentPage} page={currentPage} />
      </div>
    </Grid>
  </Grid>

  )
}

















// export const Campagns_posts_loader = async ({params})=>{
//     const {id} = params;

//       const response = await axios.get('http://127.0.0.1:8000/api/post_campaign', {
//           params: {
//             campaign_id: id
//           }
//         });
//         return response.data;
// }