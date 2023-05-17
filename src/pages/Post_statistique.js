import React, { useState, useEffect } from 'react'
import { useParams } from 'react-router-dom'
import { Grid, Typography } from '@mui/material';
import Testchart from '../components/charts/testchart/Testchart';
import Navbar from '../layouts/navbar/Navbar'
import Stat_card from '../components/charts/statCard/Stat_card';
import { Button, Space } from 'antd';
import axios from 'axios';
import Splinechart from '../components/charts/Splinechart';
import Areachart from '../components/charts/Areachart';

const Post_statistique = () => {

  const [filter, setfilter] = useState("day")
  //  const handleClickFilter =(value)=>{
  //     setfilter(value)
  //     console.log(filter)
  //  }





  const { post_id } = useParams()




  return (
    <Grid container  xs={12} md={12}>
      <Grid item xs={12} md={3}>
        {/* <Sidebar /> */}
      </Grid>
      
      <Grid  item xs={12} md={9}>
        <Grid container justifyContent="flex-start" padding={2}  item>
        <h1>Dashboard</h1>
        </Grid>
        <Grid container marginTop={1} spacing={2} >
          <Grid item xs={12} md={12}>
            <Stat_card post_id={post_id} />
          </Grid>
        </Grid>
        <Grid container marginTop={1} spacing={2} >
          <Grid item xs={12} md={12}>
            <Splinechart  />
          </Grid>
        </Grid>
        <Grid container marginTop={1} spacing={2} >
          <Grid item xs={12} md={12}>
            <Areachart  />
          </Grid>
        </Grid>
      </Grid>
      
    </Grid>
  )
}

export default Post_statistique