import * as React from 'react';
import { styled, alpha } from '@mui/material/styles';
import AppBar from '@mui/material/AppBar';
import Box from '@mui/material/Box';
import Toolbar from '@mui/material/Toolbar';
import IconButton from '@mui/material/IconButton';
import Typography from '@mui/material/Typography';
import InputBase from '@mui/material/InputBase';
import Badge from '@mui/material/Badge';
import MenuItem from '@mui/material/MenuItem';
import Menu from '@mui/material/Menu';
import MenuIcon from '@mui/icons-material/Menu';
import SearchIcon from '@mui/icons-material/Search';
import AccountCircle from '@mui/icons-material/AccountCircle';
import MailIcon from '@mui/icons-material/Mail';
import NotificationsIcon from '@mui/icons-material/Notifications';
import MoreIcon from '@mui/icons-material/MoreVert';
import { Grid } from '@mui/material';
import { Link, useParams } from 'react-router-dom';

import './navbar.css'

function Navbar() {
  
const {page_name} = useParams()
  
  return (
<Grid container >
  <Grid item md={2.5}>
    {/* <Sidebar /> */}
  </Grid>
  <Grid item md={9.5}>
    <Box  sx={{ flexGrow: 1 }}>
      <AppBar position="static" sx={{ backgroundColor: "#0000" }}>
        <Toolbar>
          {/* <IconButton
            size="large"
            edge="start"
            color="inherit"
            aria-label="open drawer"
            sx={{ mr: 2 }}
          > */}
            {/* <MenuIcon /> */}
          {/* </IconButton> */}
          {/* <Link to=":id/postlibrary"><Typography
            variant="h6"
            noWrap
            component="div"
            sx={{ display: { xs: 'none', sm: 'block' } }}
          >
            MUI
          </Typography></Link> */}
          <div className='navbar_links_container' >
          <Link className='navbar_link' to={`/${page_name}/postlibrary`}>Post Library</Link>
          <Link className='navbar_link' to={`/${page_name}/campagns`} >campagne</Link>
          </div>
          {/* <Link to=":id/postlibrary"><Typography
            variant="h6"
            noWrap
            component="div"
            sx={{ display: { xs: 'none', sm: 'block' } }}
          >
            MUI
          </Typography></Link> */}

          <Box sx={{ flexGrow: 1 }} />
          <Box sx={{ display: { xs: 'none', md: 'flex' } }}>
            {/* <IconButton size="large" aria-label="show 4 new mails" color="inherit">
              <Badge badgeContent={4} color="error">
                <MailIcon />
              </Badge>
            </IconButton> */}
            <IconButton
              size="large"
              aria-label="show 17 new notifications"
              color="inherit"
            >
              <Badge badgeContent={2} color="error">
                <NotificationsIcon color="action" />
              </Badge>
            </IconButton>
   
          </Box>
          
        </Toolbar>
      </AppBar>

    </Box>
</Grid>
</Grid>
  );
}
export default Navbar;