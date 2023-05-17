import React, { useEffect, useState } from 'react'
import {Grid } from '@mui/material';
import axios from 'axios';
import './postlibrary.css';
// import { Input } from 'antd';

//copmponents import
import Post from '../components/Post/Post';
import Paginations from '../components/pagination/Pagination';
import DatePicker from '../components/dateRangePicker/DateRangePicker';
// import Sidebar from '../layouts/sidebar/Sidebar'
import { Link, useParams } from 'react-router-dom';
// import Navbar from '../layouts/navbar/Navbar'
import Page_select from  '../components/select/Page_select'
import MediaTypeSelect from '../components/select/MediaTypeSelect';

const PostLibrary = () => {


  const {page_name} = useParams()
  
  const [dateRange, setDateRange] = useState(["",""]);
  const [startDate, endDate] = dateRange;
  const [selectedpageid, setselectedpageid] = useState('');
  const [mediatype, setmediatype] = useState('');
  const [Posts,setPosts]=useState([]);
  const [currentPage, setCurrentPage] = useState(1);
  const recordsPerPage =16;
  const [postsNumber,setpostsNumber]=useState(null);
  
  // console.log(selectedpageid)
    // const indexOfLastRecord = currentPage * recordsPerPage;
    // const indexOfFirstRecord = indexOfLastRecord - recordsPerPage;

    console.log(selectedpageid);






 
    useEffect(()=>{
      axios.get('http://127.0.0.1:8000/api/allPosts',{
        params:{
          start : startDate,
          end : endDate,
          currentPage:currentPage,
          page_name:page_name,
          selectedpageid:selectedpageid,
          mediatype:mediatype,
        }
      })
      .then(Response =>{
        setPosts(Object.values(Response.data[0]));
        setpostsNumber(Response.data[1]);
        // console.log(Response.data[0]);
      })
      .catch(error =>{
        console.log(error);
      })
    },[startDate,endDate,currentPage,selectedpageid,mediatype,page_name]);
      // console.log(Posts)
    // const currentRecords = Posts.slice(indexOfFirstRecord, 
    // indexOfLastRecord);

    const nPages=Math.ceil(postsNumber/recordsPerPage);





return(


  <Grid container spacing={2}>
    <Grid item md={2.8} paddingTop={10}>
      {/* <Sidebar /> */}
    </Grid>
    <Grid item md={9}>

        <Grid container justifyContent="flex-start" padding={2}  item>
        <h1>Post library</h1>
        </Grid>
        <Grid container justifyContent="flex-end" padding={2}  item>
        <Grid paddingRight={2}>
            {/* <Input placeholder="page name" /> */}
            <MediaTypeSelect setmediatype={setmediatype} setCurrentPage={setCurrentPage}/>
          </Grid>
          <Grid paddingRight={2}>
            {/* <Input placeholder="page name" /> */}
            <Page_select page_name={page_name} setCurrentPage={setCurrentPage}  setselectedpageid={setselectedpageid} />
          </Grid>
          <Grid>
            <DatePicker setDateRange={setDateRange} setCurrentPage={setCurrentPage}/>
          </Grid>
        </Grid>
        <Grid container spacing={4} padding={2}>
          {Posts.map(post => (
            <Grid item xs={6} md={3} sm={6} key={post.ad_id}> 
            {
              post.page_name == page_name ? (
              <>              
                <Link className='test_link' to={`${post.ad_id}`}>
                <Post data={post} />
                </Link>
              </>
              ) : (
                <>                
                <Post data={post} />
                </>
              )
            }

            </Grid>
          ))}
        </Grid>
        <Paginations nPages={nPages} setpage={setCurrentPage} page={currentPage} />
  
    </Grid>
  </Grid>


  )
}

export default PostLibrary













