import React, { useState } from 'react'
import { UploadOutlined } from '@ant-design/icons';
import DeleteIcon from '@mui/icons-material/Delete';
import './uploadfile.css'
const Uploadfile = (props) => {

 const [filename,setfilename] = useState(null)
 const [toggle,settoggle] = useState(false)
 

 const handleChange=(event)=>{
  props.setfileUrl(URL.createObjectURL(event.target.files[0]));
  setfilename(event.target.files[0].name);
  props.setfileList(event.target.files[0])
  settoggle(true)
 }
 const handleDelete=()=>{
  props.setfileList([])
  props.setfileUrl(null)
  setfilename(null)
  settoggle(false)
 }
  return (
    <>
      <label className='input_label'  htmlFor='fileSelecter'> select media content <UploadOutlined/> </label>
      <input style={{display:'none'}} id='fileSelecter' onChange={handleChange} type='file' multiple accept='image/* , video/*'/>
      <div style={{display:'flex'}}>
        <p className='file_name'>{filename}</p>
        <button className={toggle ?'active' : 'desactive' } onClick={handleDelete}> <DeleteIcon className='delete_icon'/> </button>
      </div>
    </>
    )
}

export default Uploadfile