import React from 'react';
import Table from '@mui/material/Table';
import TableBody from '@mui/material/TableBody';
import TableCell from '@mui/material/TableCell';
import TableContainer from '@mui/material/TableContainer';
import TableHead from '@mui/material/TableHead';
import TableRow from '@mui/material/TableRow';
import Paper from '@mui/material/Paper';
import './campaigns_table.css';
import { Link } from 'react-router-dom';
import RemoveRedEyeIcon from '@mui/icons-material/RemoveRedEye';






  
  

  

const Campaigns_table = (props) => {



  return (
    <TableContainer component={Paper}>
      <Table sx={{ minWidth: 650 }} size="small" aria-label="a dense table">
        <TableHead>
          <TableRow>
            <TableCell>name</TableCell>
            <TableCell align="right">start_time</TableCell>
            <TableCell align="right">stop_time</TableCell>
            <TableCell align="right">objective</TableCell>
            <TableCell align="center">status</TableCell>
            <TableCell align="right">action</TableCell>

          </TableRow>
        </TableHead>
        <TableBody>
          {props.campaigns.map((campaign) => (
            // <Link className='tableLink' to={`${campaign.id}`}> 
            <TableRow
              key={campaign.id} 
            >
              
              <TableCell >{campaign.name}</TableCell>
             
              <TableCell align="right">{campaign.start_time}</TableCell>
              <TableCell align="right">{campaign.stop_time}</TableCell>
              <TableCell align="right">{campaign.objective}</TableCell>
              <TableCell align="right"><div className={campaign.status==='ACTIVE' ?'status_active'   : 'status-paused'}>{campaign.status}</div></TableCell>
              <TableCell align="right">
               <Link className='tableLink' to={`${campaign.id}`}>
                <RemoveRedEyeIcon/>
               </Link>
                </TableCell>
            </TableRow>
            // </Link>
          ))}

        </TableBody>
      </Table>
    </TableContainer>
  );
}

export default Campaigns_table