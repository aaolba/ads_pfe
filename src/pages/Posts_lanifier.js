import React from 'react'
import { Grid } from '@mui/material'
import DemoApp from '../components/calender/calender'
import { Link } from 'react-router-dom'
import './post_planification.css'
const Posts_lanifier = () => {
  return (
<Grid container  xs={12} md={12}>
      <Grid item xs={12} md={2.8}>
        {/* <Sidebar /> */}
      </Grid>
      <Grid paddingBottom={3} paddingTop={7} item xs={12} md={9}>
    <Grid container justifyContent="flex-end" paddingBottom={4}>
        <Link className='Create_link' to='create'>Create</Link>
    </Grid>
        <DemoApp/>
    </Grid>
</Grid>

  )
}

export default Posts_lanifier