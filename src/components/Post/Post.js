import * as React from 'react';
import { styled } from '@mui/material/styles';
import Card from '@mui/material/Card';
import CardHeader from '@mui/material/CardHeader';
import CardMedia from '@mui/material/CardMedia';
import CardContent from '@mui/material/CardContent';
import CardActions from '@mui/material/CardActions';
import Collapse from '@mui/material/Collapse';
import Avatar from '@mui/material/Avatar';
import IconButton from '@mui/material/IconButton';
import Typography from '@mui/material/Typography';
import { red } from '@mui/material/colors';
import FavoriteIcon from '@mui/icons-material/Favorite';
import ShareIcon from '@mui/icons-material/Share';
import ExpandMoreIcon from '@mui/icons-material/ExpandMore';
import MoreVertIcon from '@mui/icons-material/MoreVert';
import './post.css';
import { Grid } from '@mui/material';


const ExpandMore = styled((props) => {
  const { expand, ...other } = props;
  return <IconButton {...other} />;
})(({ theme, expand }) => ({
  transform: !expand ? 'rotate(0deg)' : 'rotate(180deg)',
  marginLeft: 'auto',
  transition: theme.transitions.create('transform', {
    duration: theme.transitions.duration.shortest,
  }),
}));

const Posts = (props) => {


  // const [expanded, setExpanded] = React.useState(false);

  // const handleExpandClick = () => {
  //   setExpanded(!expanded);
  // };

  return (
    <Card sx={{minHeight:350}}>
      <CardHeader
        avatar={
          <Avatar  src={props.data.page_image_url} />
        }
        // action={
        //   <IconButton aria-label="settings">
        //     <MoreVertIcon />
        //   </IconButton>
        // }
        title={props.data.page_name}
        subheader={props.data.created_time}

      />
      <p className='status'>{props.data.status}</p>
      <CardContent>
        <div className='style' nowrap>
        <Typography  className='style2'  variant="body2" color="text.secondary">
          {props.data.message}
        </Typography>
        </div>
      </CardContent>
      <CardMedia
        component="img"
        height="370"
        image={props.data.image_url}
      />

{/* 
      <Grid container spacing={2} padding={2}  alignItems="center"  >
        <Grid item md={4}>
          <Grid item md={12}>
          <Typography variant='subtitle2'>
            0
          </Typography>
          </Grid>
          <Grid item md={12}>
          <Typography variant='body2'>
          Reactions
          </Typography>
          </Grid>
        </Grid>

        <Grid item md={4}>
          <Grid item md={12}>
          <Typography variant='subtitle2'>
            0
          </Typography>
          </Grid>
          <Grid item md={12}>
          <Typography variant='body2'>
          Comments
          </Typography>
          </Grid>
        </Grid>


        <Grid item md={4}>
          <Grid item md={12}>
          <Typography variant='subtitle2'>
            0
          </Typography>
          </Grid>
          <Grid item md={12}>
          <Typography variant='body2'>
          Shares
          </Typography>
          </Grid>
        </Grid>


        <Grid item md={4}>
          <Grid item md={12}>
          <Typography variant='subtitle2'>
            0
          </Typography>
          </Grid>
          <Grid item md={12}>
          <Typography variant='body2'>
          Engagement
          </Typography>
          </Grid>
        </Grid>


        <Grid item md={4}>
          <Grid item md={12}>
          <Typography variant='subtitle2'>
            0
          </Typography>
          </Grid>
          <Grid item md={12}>
          <Typography variant='body2'>
          Views
          </Typography>
          </Grid>
        </Grid>
        

        <Grid item md={4}>
          <Grid item md={12}>
          <Typography variant='subtitle2'>
            0
          </Typography>
          </Grid>
          <Grid item md={12}>
          <Typography variant='body2'>
          Portée
          </Typography>
          </Grid>
        </Grid>

        
      <Grid item md={4}>
          <Grid item md={12}>
          <Typography variant='subtitle2'>
            0
          </Typography>
          </Grid>
          <Grid item md={12}>
          <Typography variant='body2'>
          Clicks
          </Typography>
          </Grid>
        </Grid>
      </Grid> */}

     

      
    </Card>
  )
}

export default Posts