import React, { useEffect, useState } from 'react'
import './sidebar.css'
import {Grid } from '@mui/material';
import axios from 'axios';
//logo import 
import logo from './logo.png'
import facebookIcon from './icons8-facebook.svg'
import { Link, Outlet, useParams } from 'react-router-dom'
//icon import
import CalendarMonthIcon from '@mui/icons-material/CalendarMonth';
import PhotoLibraryIcon from '@mui/icons-material/PhotoLibrary';
import CampaignIcon from '@mui/icons-material/Campaign';
const Sidebar = () => {

    const [pages,setpages]= useState([])
    useEffect(() => {
          axios.get('http://127.0.0.1:8000/api/pages')
          .then(response => {
            setpages(response.data);
            console.log(pages)
          })
          .catch(error => {
            console.log(error);
          });
        },[]);


        const {page_name} = useParams()




  const [toggle,setoggle]=useState(true);
  return (
    <>
    <Grid item md={2.8} paddingTop={0.01}>
  
    {/* <Sidebar /> */}

    <div className='sidebar-container'>
      <div className='sidebar-pages-container'>
        <div className='sidebar-logo-container'>
        <Link to='/'><img src={logo} alt='logo'/></Link>
        </div>
        <div className='sidebar-facebook-pages-container'>
          <img src={facebookIcon} alt='facebook icon' onClick={()=>{setoggle(!toggle)}}/>
          <div className={toggle ?'sidebar-pages-active'   : 'sidebar-pages-inactive'}>
            {
              pages.map((page)=>{
                return(
                 
                    <Link to={`${page['page_name']}/postlibrary`} ><img className='pageimage' src={page['page_image_url']} alt="text"/></Link>
          
              )})
            } 
          </div>
        </div>
        
      </div>
      <div className='sidebar-rightside-container'>
      <div className='sidebar-design-part'>

      </div>
      <div className='sidebar-links-container'>
      {page_name != undefined ? (
        <>
        <Link className='sidebar-link' to={`/${page_name}/postlibrary`}><PhotoLibraryIcon/>    Post Library</Link>
        <Link className='sidebar-link' to={`/${page_name}/campagns`} > <CampaignIcon/> campagne</Link>
        <Link className='sidebar-link' to={`/${page_name}/schedule`} > <CalendarMonthIcon/> schedule</Link>
        </>
      ): (
        <>
        <p className='sidebar-link' to={`/${page_name}/postlibrary`}><PhotoLibraryIcon/>    Post Library</p>
        <p className='sidebar-link' to={`/${page_name}/campagns`} > <CampaignIcon/> campagne</p>
        <p className='sidebar-link' to={`/${page_name}/schedule`} > <CalendarMonthIcon/> schedule</p>
        </>
      )}
      </div>
      </div>
    </div>
    </Grid>
    <Outlet/>
    </>
  )
}

export default Sidebar