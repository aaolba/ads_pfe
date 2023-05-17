import { useEffect, useState } from 'react'
import { Grid } from '@mui/material'
import { Button, Space,Upload  } from 'antd';
import TextAreaInput from '../components/TextAreaInput/TextAreaInput';
import DateTimePicker from '../components/dateRangePicker/DateTmePicker';
import IconButton from '@mui/material/IconButton';
import MoreHorizIcon from '@mui/icons-material/MoreHoriz';import './create_post.css'
import ReplyIcon from '@mui/icons-material/Reply';
import { UploadOutlined } from '@ant-design/icons';
import ThumbUpOffAltIcon from '@mui/icons-material/ThumbUpOffAlt';
import ChatBubbleOutlineIcon from '@mui/icons-material/ChatBubbleOutline';
import axios from 'axios';
import Uploadfile from '../components/uploadfile/Uploadfile';
import { useParams } from 'react-router-dom';
const Create_post = () => {


    const {page_name} = useParams()
    const [fileUrl,setfileUrl] = useState(null)
    const [fileList,setfileList] = useState([])
    // console.log(fileList)
    const [loading,setloading] = useState(false);
    const [Brief, setBrief] = useState('');
    const [Postmessage, setPostmessage] = useState('');
    const [planingTime, setPlaningTime] = useState('');
    const [pageDetails,setPageDetails] = useState()
console.log(planingTime)

useEffect(()=>{
    axios.get('http://127.0.0.1:8000/api/getpageDetails',{
        params:{

            page_name:page_name,
        }
    })
      .then(Response =>{
        setPageDetails(Response.data[0])
    })
    .catch(error =>{
        console.log(error);
    })   
    
},[])


const schadule =() =>{
    if((Postmessage=="" || fileUrl == null) && planingTime =='' ){
        alert('you need to make a content validation')
        return 0
    }
    const formData = new FormData();
    formData.append('file',fileList)
    formData.append('Postmessage', Postmessage);
    formData.append('planingTime', planingTime);
    axios.post('http://127.0.0.1:8000/api/storePhoto',formData)
      .then(Response =>{
        console.log(Response.data)
      })
      .catch(error =>{
        console.log(error);
      })   
}

const publichnow =() =>{
    if(Postmessage=="" || fileUrl == null){
        alert('you need to make a content validation')
        return 0
    }
    const formData = new FormData();
    formData.append('file',fileList)
    formData.append('Postmessage', Postmessage);
    axios.post('http://127.0.0.1:8000/api/publichnow',formData)
      .then(Response =>{
        console.log(Response.data)
      })
      .catch(error =>{
        console.log(error);
      })   
}



    const sendBreif=()=>{
        setloading(true)
        console.log("done")
        axios.get('http://127.0.0.1:8000/api/gptGenerate',{
            params:{
                Brief:Brief,
            }
          })
          .then(Response =>{
            setPostmessage(Response.data)
            console.log(Postmessage);
            setloading(false)
          })
          .catch(error =>{
            console.log(error);
          })   
    }

    return (
        <Grid container xs={12} md={12}>
            <Grid item xs={12} md={2.8}>
                {/* <Sidebar /> */}
            </Grid>












            <Grid item xs={12} md={4.7}>

                <Grid container justifyContent="flex-start" padding={2} item>
                    <h1>Create post</h1>
                </Grid>
                <Grid paddingTop={3}>
                    <TextAreaInput line_nbr={3} setvalue={setBrief} content={Brief} placeholder={'breif'}/>
                </Grid>
                <Grid paddingTop={1}>
                    <Button onClick={sendBreif} loading={loading} type="primary">submit</Button>
                </Grid>
                <Grid paddingTop={3}>
                    <TextAreaInput line_nbr={7} setvalue={setPostmessage} content={Postmessage} placeholder={'post message'}/>
                </Grid>
                <Grid paddingTop={2}>
                    <Uploadfile setfileUrl={setfileUrl} setfileList={setfileList} />
                    
                </Grid>

                <Grid paddingTop={3}>
                    <DateTimePicker setPlaningTime={setPlaningTime} />
                </Grid>


                <Grid paddingTop={2} paddingBottom={2}  container  >
                <Grid paddingTop={1}>
                    <Button onClick={schadule} type="primary">schadule post</Button>
                </Grid>
                <Grid paddingTop={1} paddingLeft={3}>
                    <Button onClick={publichnow} type="primary">publish </Button>
                </Grid>
                </Grid>
            </Grid>


















            <Grid item xs={12} md={4.5}>
                <Grid container justifyContent="flex-start" paddingTop={12.4} paddingLeft={7} item>
                  
                  {Postmessage||fileUrl ? (
                   <div className='post_body'>
                        <div className='post_header'>
                            <div style={{display:'flex'}}>
                            <img className='create_post_page_logo' src={pageDetails?.page_image_url}/>
                            <div className='header_text'>
                                <h3>{pageDetails?.page_name}</h3>
                                <p>à l'instant</p>
                            </div>
                            </div>
                                <MoreHorizIcon />
                        </div>
                        <div className='post_content'>
                            <p> {Postmessage} </p>
                        </div>
                        <div className='create_post_core_img'>
                       {fileUrl && <img className='core_img' src={fileUrl}/>}
                        </div>
                        <div className='create_post_footer'>
                            <div className='create_post_reaction'>
                                <ThumbUpOffAltIcon/>
                                <p>J'aime</p></div>
                            <div className='create_post_reaction'>
                                <ChatBubbleOutlineIcon/>
                                <p>Commenter</p></div>
                            <div className='create_post_reaction'> 
                                <ReplyIcon/>
                                <p>Partager</p>
                            </div>
                        </div>


                    </div> 
                    ): (<></>)}
                </Grid>

            </Grid>
        </Grid>
    )
}

export default Create_post;