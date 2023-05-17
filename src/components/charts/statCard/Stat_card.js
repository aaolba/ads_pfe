import React, {useEffect,useState} from 'react'
import './stat_card.css'
import PaidIcon from '@mui/icons-material/Paid';
import AddReactionIcon from '@mui/icons-material/AddReaction';
import { Grid } from '@mui/material';
import axios from 'axios';
import CallMadeIcon from '@mui/icons-material/CallMade';
import CallReceivedIcon from '@mui/icons-material/CallReceived';
const Stat_card = (props) => {
 const [insight,setinsight] = useState([])
 const [insightDiffrence,setinsightDiffrence] = useState([])
  useEffect(() => {
    axios.get('http://127.0.0.1:8000/api/card_insights',{
      params: {
        post_id: props.post_id,
      }
    })
    .then(response => {
      setinsight(response.data[0]);
      setinsightDiffrence(response.data[1])
      console.log(insightDiffrence)
    })
    .catch(error => {
      console.log(error);
    });
  },[]);

  // console.log(insight)


  return (
<Grid container spacing={2} paddingRight={5}>
  <Grid item xs={12} sm={6} md={3}>
  <div className='stat_card_body'>
    <h3 className='stat_card_title'>total post Clicks</h3>
    <div className='stat_card_body_container'>
      <h2 className='stat_card_value'>{insight.clicks}</h2>
      <div className='stat_card_augmentation'>
        <CallMadeIcon/>
        <p>{insightDiffrence['clicks_difference']}</p>
      </div>
    </div>
  </div>
  </Grid>
  <Grid item xs={12} sm={6} md={3}>
  <div className='stat_card_body'>
    <h3 className='stat_card_title'>total post Reach</h3>
    <div className='stat_card_body_container'>
      <h2 className='stat_card_value'>{insight.reach}</h2>
      <div className='stat_card_augmentation'>
        <CallMadeIcon/>
        <p>{insightDiffrence['reach_difference']}</p>
      </div>
    </div>
  </div>
  </Grid>
  <Grid item xs={12} sm={6} md={3}>
  <div className='stat_card_body'>
    <h3 className='stat_card_title'>total post Impression</h3>
    <div className='stat_card_body_container'>
      <h2 className='stat_card_value'>{insight.impressions}</h2>
      <div className='stat_card_augmentation'>
        <CallMadeIcon/>
        <p>{insightDiffrence['impression_difference']}</p>
      </div>
    </div>
  </div>
  </Grid>
  <Grid item xs={12} sm={6} md={3}>
  <div className='stat_card_body'>
    <h3 className='stat_card_title'>total post Spend</h3>
    <div className='stat_card_body_container'>
      <h2 className='stat_card_value'>{insight.spend} $</h2>
      {/* <div className='stat_card_augmentation'>
        <CallReceivedIcon/>
        <p>25%</p>
      </div> */}
    </div>
  </div>
  </Grid>
</Grid>


  )
}

export default Stat_card